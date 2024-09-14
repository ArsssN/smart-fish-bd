<?php

namespace App\Console\Commands;

use App\Http\Controllers\MqttCommandController;
use App\Models\MqttData;
use App\Models\MqttDataSwitchUnitHistory;
use App\Models\Pond;
use App\Models\SwitchUnitSwitch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use PhpMqtt\Client\Facades\MQTT;

class _AeratorManageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aerator:manage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var array - machine status options (on, off)
     */
    const machineStatus = [
        'on' => 'on',
        'off' => 'off'
    ];

    /**
     * @var array - default switches
     */
    const defaultSwitches = [
        [
            'number' => 1,
            'switch_type_id' => 2,
            'status' => 'off',
            'comment' => null
        ],
        [
            'number' => 2,
            'switch_type_id' => 2,
            'status' => 'off',
            'comment' => null
        ],
        [
            'number' => 3,
            'switch_type_id' => 2,
            'status' => 'off',
            'comment' => null
        ],
        [
            'number' => 4,
            'switch_type_id' => 2,
            'status' => 'off',
            'comment' => null
        ],
        [
            'number' => 5,
            'switch_type_id' => 2,
            'status' => 'off',
            'comment' => null
        ],
        [
            'number' => 6,
            'switch_type_id' => 2,
            'status' => 'off',
            'comment' => null
        ],
        [
            'number' => 7,
            'switch_type_id' => 2,
            'status' => 'off',
            'comment' => null
        ],
        [
            'number' => 8,
            'switch_type_id' => 2,
            'status' => 'off',
            'comment' => null
        ],
        [
            'number' => 9,
            'switch_type_id' => 2,
            'status' => 'off',
            'comment' => null
        ],
        [
            'number' => 10,
            'switch_type_id' => 2,
            'status' => 'off',
            'comment' => null
        ],
        [
            'number' => 11,
            'switch_type_id' => 2,
            'status' => 'off',
            'comment' => null
        ],
        [
            'number' => 12,
            'switch_type_id' => 2,
            'status' => 'off',
            'comment' => null
        ],
    ];

    /**
     * @var int - start after time in min: 20
     */
    const switchOnAfter = 20 * 60; // seconds

    /**
     * @var int - stop after time in min: 40
     */
    const switchOffAfter = 40 * 60; // seconds

    /**
     * @var int - switch type id (aerator)
     */
    const aeratorSwitchTypeID = 1;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        Log::channel('aerator_status')->info('Aerator Manage Command Starting');
        $switchUnitSwitchesList = SwitchUnitSwitch::query()
            ->whereHas('switchUnit.ponds', function ($query) {
                $query->where('status', 'active');
            })
            ->with('switchUnit.ponds')
            /*->whereHas('switchType', function ($query) {
                $query->where('remote_name', 'aerator');
            })*/
            ->whereNotNull('run_status_updated_at')
            ->get();

        $switchUnitSwitchesBySwitchUnitID = $switchUnitSwitchesList->groupBy('switch_unit_id');

        foreach ($switchUnitSwitchesBySwitchUnitID as $switchUnitID => $switchUnitSwitches) {
            $switchUnit = $switchUnitSwitches->first()->switchUnit;

            $relay = array_fill(1, 12, 0);
            $mqttDataSwitchUnitHistory = MqttDataSwitchUnitHistory::query()
                ->where('switch_unit_id', $switchUnitID)
                ->with('mqttData')
                ->orderByDesc('id')
                ->first();

            $mqttData = $mqttDataSwitchUnitHistory->mqttData;
            $publish_message = json_decode($mqttData->publish_message ?? '{}');
            $publish_topic = $mqttData->publish_topic;
            $previous_relay = $publish_message->relay
                ?: implode('', array_fill(1, 12, 0));

            $historyDetails = self::defaultSwitches;

            $switchUnitSwitches->each(function ($switchUnitSwitch, $index) use (&$relay, &$historyDetails) {
                $run_status = $switchUnitSwitch->run_status;
                $run_status_updated_at = $switchUnitSwitch->run_status_updated_at;

                if ($switchUnitSwitch->switchType == self::aeratorSwitchTypeID) {
                    $onAbleTime = $run_status_updated_at->diffInSeconds(now()) >= self::switchOnAfter;
                    $offAbleTime = $run_status_updated_at->diffInSeconds(now()) >= self::switchOffAfter;

                    if ($run_status === 'on' && $offAbleTime) {
                        Log::channel('aerator_status')->info('When run status on and offAbleTim switch : ' . $historyDetails[$index]['number'] ?? '--' . ', Time: ' . now());
                        $switchUnitSwitch->update([
                            'run_status' => 'off',
                            'run_status_updated_at' => now(),
                            'status' => 'off'
                        ]);
                    } else if ($run_status === 'off' && $onAbleTime) {
                        Log::channel('aerator_status')->info('When run status off and onAbleTim switch : ' . $historyDetails[$index]['number'] ?? '--' . ', Time: ' . now());
                        $switchUnitSwitch->update([
                            'run_status' => 'on',
                            'run_status_updated_at' => null,
                        ]);
                    }
                }

                $historyDetails[$index] = [
                    ...$historyDetails[$index],
                    'status' => $switchUnitSwitch->status,
                    'comment' => $switchUnitSwitch->comment,
                    'switch_type_id' => $switchUnitSwitch->switchType,
                ];

                $relay[$switchUnitSwitch->number] = $switchUnitSwitch->status === 'on' ? 1 : 0;
            });

            Log::channel('aerator_status')->info('Previous relay : ' . $previous_relay .', New Relay ' . implode(', ', $relay));

            if (($newRelayStr = implode('', $relay)) !== $previous_relay) {
                $publish_message->relay = $newRelayStr;

                $newMqttData = MqttData::query()->create([
                    'type' => 'sensor',
                    'project_id' => $mqttData->project_id,
                    'data' => $mqttData->data,
                    'data_source' => 'scheduler',
                    'original_data' => $mqttData?->original_data ?? $mqttData?->data,
                    'publish_message' => json_encode($publish_message),
                    'publish_topic' => $publish_topic,
                ]);

                $switchUnit->ponds->each(function ($pond) use ($switchUnit, $newMqttData, $historyDetails) {
                    $mqttDataSwitchUnitHistory = MqttDataSwitchUnitHistory::query()->create([
                        'mqtt_data_id' => $newMqttData->id,
                        'pond_id' => $pond->id,
                        'switch_unit_id' => $switchUnit->id,
                    ]);

                    $mqttDataSwitchUnitHistory->switchUnitHistoryDetails()->createMany($historyDetails);
                });
                Log::channel('aerator_status')->info('Topic : ' . $publish_topic . ', Message: ' . json_encode($publish_message));

                MQTT::publish($publish_topic, json_encode($publish_message));
            }
        }
    }
}