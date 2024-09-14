<?php

namespace App\Console\Commands;

use App\Models\SwitchUnit;
use App\Services\MqttHistoryDataService;
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
            ->with(['switchUnitSwitches:id,switch_unit_id,switchType,status',
                'history' => function ($query) {
                    $query->select('id', 'mqtt_data_id', 'switch_unit_id')
                        ->with('mqttData:id,publish_topic,publish_message,project_id,original_data,data');
                }
            ])->whereNotNull('run_status_updated_at')
            ->get();

        foreach ($switchUnits as $switchUnit) {
            $runStatus = $switchUnit->run_status;
            $runStatusUpdatedAt = $switchUnit->run_status_updated_at;

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
                    $relay = $this->switchUnitSwitchesStatusOff($switchUnit->switchUnitSwitches, $historyDetails);

                    $mqttData = $switchUnit->history->mqttData;

                    $publishMessage = json_decode($mqttData->publish_message ?? '{}');
                    $publishTopic = $mqttData->publish_topic;
                    $previousRelay = $publishMessage->relay
                        ?: implode('', array_fill(1, count($switchUnit->switchUnitSwitches), 0));

                    MqttPublishService::relayPublish($publishTopic, $relay, $publishMessage->addr, $previousRelay);

                    //mqtt data and history data save
                    MqttHistoryDataService::mqttDataSave($mqttData, $publishTopic);
                    MqttHistoryDataService::mqttDataSwitchUnitHistorySave($switchUnit, $historyDetails);

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
     * @return string
     */
    public function switchUnitSwitchesStatusOff($switchUnitSwitches, &$historyDetails): string
    {
        $relay = [];
        foreach ($switchUnitSwitches as $index => $switchUnitSwitch) {
            $switchUnitSwitch->status = 'off';
            $switchUnitSwitch->save();
            $relay[] = $switchUnitSwitch->status === 'off' ? 0 : 1;

            $historyDetails[$index] = [
                'status' => $switchUnitSwitch->status,
                'comment' => $switchUnitSwitch->comment,
                'switch_type_id' => $switchUnitSwitch->switchType,
            ];
        }
        return implode('', $relay);
    }

}
