<?php

namespace App\Console\Commands;

use App\Models\SwitchUnit;
use App\Services\MqttStoreService;
use App\Services\MqttPublishService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class AeratorManageCommand extends Command
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
     * @var int - start after time in min: 20
     */
    const switchOnAfter = 20 * 60; // seconds

    /**
     * @var int - stop after time in min: 40
     */
    const switchOffAfter = 40 * 60; // seconds

    /**
     * Execute the console command.
     *
     * @return void
     * @throws Throwable
     */
    public function handle(): void
    {
        Log::channel('aerator_status')->info('Aerator Manage Command Starting');

        $switchUnits = SwitchUnit::query()
            ->select('id', 'run_status', 'run_status_updated_at')
            ->whereRelation('ponds', 'status', 'active')
            ->with([
                'switchUnitSwitches:id,number,switch_unit_id,switchType,status,comment',
                'ponds:id',
                'history' => function ($query) {
                    $query->select('id', 'mqtt_data_id', 'switch_unit_id')
                        ->with('mqttData:id,publish_topic,publish_message,project_id,original_data,data');
                }
            ])
            ->whereNotNull('run_status_updated_at')
            ->get();

        foreach ($switchUnits as $switchUnit) {
            $runStatus = $switchUnit->run_status;
            $runStatusUpdatedAt = $switchUnit->run_status_updated_at;

            MqttStoreService::$mqttDataSwitchUnitHistory = [
                'pond_id' => $switchUnit->ponds->firstOrFail()?->id,
                'switch_unit_id' => $switchUnit->id,
            ];

            try {
                DB::beginTransaction();

                if ($runStatus === 'on' && $runStatusUpdatedAt->diffInSeconds(now()) >= self::switchOffAfter) {
                    Log::channel('aerator_status')->info('When run status on and offAbleTim switch : ' . $switchUnit->name . '--' . ', Time: ' . now());
                    $switchUnit->update([
                        'run_status' => 'off',
                        'run_status_updated_at' => now()
                    ]);

                    $historyDetails = [];
                    // switch unit switches status off
                    $relay = $this->switchUnitSwitchesStatusUpdate($switchUnit->switchUnitSwitches, $historyDetails);

                    $mqttData = $switchUnit->history->mqttData;

                    $publishMessage = json_decode($mqttData->publish_message ?? '{}');
                    $publishTopic = $mqttData->publish_topic;
                    $previousRelay = $publishMessage->relay
                        ?: implode('', array_fill(1, count($switchUnit->switchUnitSwitches), 0));

                    /**
                     * mqtt publish
                     *
                     * Publish must be before store if present.
                     */
                    MqttPublishService::init($publishTopic, $relay, $publishMessage->addr, $previousRelay)->relayPublish();

                    /**
                     * mqtt data and history data save.
                     *
                     * Store must be after mqtt publish if present.
                     */
                    MqttStoreService::init($publishTopic, $mqttData, $switchUnit, $historyDetails)
                        ->mqttDataSave()
                        ->mqttDataSwitchUnitHistorySave()
                        ->mqttDataSwitchUnitHistoryDetailsSave();
                } else if ($runStatus === 'off' && $runStatusUpdatedAt->diffInSeconds(now()) >= self::switchOnAfter) {
                    Log::channel('aerator_status')->info('When run status off and onAbleTim switch : ' . $switchUnit->name . '--' . ', Time: ' . now());
                    $switchUnit->update([
                        'run_status' => 'on',
                        'run_status_updated_at' => null,
                    ]);
                }
                DB::commit();
            } catch (Exception $exception) {
                DB::rollBack();
                throw $exception;
            }
        }
    }

    /**
     * switch unit switches updating
     *
     * @param $switchUnitSwitches
     * @param $historyDetails
     * @param string $status
     * @return string
     */
    public function switchUnitSwitchesStatusUpdate($switchUnitSwitches, &$historyDetails, string $status = 'off'): string
    {
        $relay = [];
        foreach ($switchUnitSwitches as $index => $switchUnitSwitch) {
            $switchUnitSwitch->status = $status;
            $switchUnitSwitch->save();
            $relay[] = $switchUnitSwitch->status === 'off' ? 0 : 1;

            $historyDetails[$index] = [
                'number' => $switchUnitSwitch->number,
                'status' => $switchUnitSwitch->status,
                'comment' => $switchUnitSwitch->comment,
                'switch_type_id' => $switchUnitSwitch->switchType,
            ];
        }
        return implode('', $relay);
    }
}
