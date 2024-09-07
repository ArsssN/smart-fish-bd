<?php

namespace App\Http\Controllers;

use App\Console\Commands\MqttListener;
use App\Models\MqttData;
use App\Models\MqttDataSwitchUnitHistory;
use App\Models\MqttDataSwitchUnitHistoryDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class MqttCommandController extends Controller
{
    /**
     * @var MqttData|Model|Builder $mqttData - mqtt data
     */
    public static MqttData|Model|Builder $mqttData;

    /**
     * @var array $feedBackArray - feedback array
     */
    public static array $feedBackArray = [
        'addr' => '',
        'type' => 'sw',
        'relay' => '000000000000',
    ];

    /**
     * @var bool $isSaveMqttData - flag to check if the mqtt data should be saved
     */
    public static bool $isSaveMqttData = true;

    /**
     * @var string $switchUnitStatus - switch unit status
     */
    public static string $switchUnitStatus = 'active';

    /**
     * @var bool $isAlreadyPublished - flag to check if the mqtt data is already published
     */
    public static bool $isAlreadyPublished = false;

    /**
     * @param $type            string - unit type (sensor, switch, etc)
     * @param $responseMessage object - response message from mqtt
     * @param $topic           string - mqtt topic
     *
     * @return void
     */
    public static function saveMqttData(string $type, object $responseMessage, string $topic): void
    {
        $newResponseMessage = new \stdClass();
        $newResponseMessage->gateway_serial_number = $responseMessage->gw_id;
        $newResponseMessage->type = $type;
        $newResponseMessage->serial_number = hexdec($responseMessage->addr);
        $newResponseMessage->data = $responseMessage->data;

        $remoteNames = collect($responseMessage->data)->keys()->toArray();
        $serialNumber = hexdec($responseMessage->addr);

        $model = 'App\Models\\' . Str::ucfirst($type) . 'Unit';

        $typeUnit = $model::query()
            ->where('serial_number', $serialNumber)
            ->with("{$type}Types", "ponds")
            ->whereHas("{$type}Types", function ($query) use ($remoteNames) {
                $query->whereIn('remote_name', $remoteNames);
            })
            ->whereHas("ponds", function ($query) use ($newResponseMessage) {
                $query->whereHas("project", function ($query) use ($newResponseMessage) {
                    $query->where('gateway_serial_number', $newResponseMessage->gateway_serial_number);
                });
            })
            ->firstOrFail();

        $pond = $typeUnit->ponds->firstOrFail();

        $switchUnit = $pond->switchUnits->firstOrFail();
        $addr = dechex((int)$switchUnit->serial_number);
        self::$feedBackArray['addr'] = Str::startsWith($addr, '0x') ? $addr : '0x' . $addr;
        self::$switchUnitStatus = $switchUnit->status;
        $project = $pond->project;

        $switchState = array_fill(0, 12, 0);

        $projectID = $project->id;

        $mqttData = MqttData::query();
        if (self::$isSaveMqttData) {
            $mqttData = $mqttData->create([
                'type' => $type,
                'project_id' => $projectID,
                'data' => json_encode($responseMessage),
                'original_data' => MqttListener::getOriginalMessage(),
                'publish_topic' => $topic,
                'publish_message' => json_encode([
                    'addr' => $responseMessage->addr,
                    'type' => $responseMessage->type,
                    'relay' => implode('', $switchState),
                ])
            ]);
        }
        self::$mqttData = $mqttData;

        $typeUnit->{$type . 'Types'}
            ->each(
                function ($typeType)
                use ($typeUnit, $type, $responseMessage, &$switchState) {
                    self::saveMqttDataHistory($typeType, $typeUnit, $type, $responseMessage, $switchState);
                }
            );

        if (self::$isSaveMqttData) {
            self::changeSwitchStateOfSensorUnit($typeUnit->ponds, $switchState);
        }

        self::$feedBackArray['relay'] = implode('', $switchState);

        // Confirms if the relay is empty or null, if empty or null then set it to 000000000000
        if (!(bool)self::$feedBackArray['relay']) {
            self::$feedBackArray['relay'] = implode('', array_fill(0, 12, 0));
        }
    }

    /**
     * Save mqtt data history
     *
     * @param $typeType
     * @param $typeUnit
     * @param $type
     * @param $responseMessage
     * @param $switchState
     *
     * @return void
     */
    private static function saveMqttDataHistory(
        $typeType, $typeUnit, $type, $responseMessage, &$switchState
    ): void
    {
        $typeUnitID = $typeUnit->id;
        $typeTypeID = $typeType->id;
        $remoteName = $typeType->remote_name;
        if (!isset($responseMessage->data->$remoteName)) {
            return;
        }
        $value = $responseMessage->data->$remoteName;

        $typeName = Str::replace(' ', '', $typeType->name);
        $helperMethodName = "get{$typeName}Update";

        if (function_exists($helperMethodName)) {
            $type_message = ($helperMethodName(
                $value,
            ));

            // if array
            if (is_array($type_message)) {
                $switchState = $typeType->can_switch_sensor
                    ? mergeSwitchArray(
                        $type_message,
                        $switchState
                    ) : $switchState;

                $type_message = implode(', ', $type_message);
            }
        } else {
            $type_message = "No helper method found for $type: {$typeType->name}";
        }

        if (self::$isSaveMqttData) {
            $typeUnit->ponds->each(
                function ($pond)
                use ($type, $typeUnitID, $typeTypeID, $value, $type_message
                ) {
                    $pondID = $pond->id;

                    self::$mqttData->histories()->create([
                        'pond_id' => $pondID,
                        "{$type}_unit_id" => $typeUnitID,
                        "{$type}_type_id" => $typeTypeID,
                        'value' => $value,
                        'type' => $type,
                        'message' => $type_message,
                    ]);
                });
        }
    }

    /**
     * @param $ponds
     * @param $switchState
     *
     * @return void
     */
    private static function changeSwitchStateOfSensorUnit($ponds, $switchState): void
    {
        $ponds->each(function ($pond) use ($switchState) {
            $mqttDataSwitchUnitHistories = [];
            $pond->switchUnits->each(
                function ($switchUnit)
                use ($switchState, &$mqttDataSwitchUnitHistories
                ) {
                    $switches = collect($switchUnit->switches ?? '[]');
                    $switches = $switches->map(function ($switch, $index) use ($switchState) {
                        $switch['status'] = $switchState[$index]
                            ? 'on'
                            : 'off';

                        return $switch;
                    });

                    $switchUnit->switches = $switches->toArray();
                    $switchUnit->save();

                    if (self::$mqttData->id) {
                        $mqttDataSwitchUnitHistory = [
                            'mqtt_data_id' => self::$mqttData->id,
                            'pond_id' => $switchUnit->pivot->pond_id,
                            'switch_unit_id' => $switchUnit->id,
                            //'switches' => json_encode($switches),
                            'switches' => json_encode(collect()),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                        $mqttDataSwitchUnitHistories[] = $mqttDataSwitchUnitHistory;
                        $newMqttDataSwitchUnitHistory = MqttDataSwitchUnitHistory::query()->create($mqttDataSwitchUnitHistory);
                        //dd($newMqttDataSwitchUnitHistory, $switches);

                        foreach ($switchUnit->switches as $switchDetail) {
                            $detail = [
                                'history_id' => $newMqttDataSwitchUnitHistory->id,
                                'number' => $switchDetail['number'],
                                'switch_type_id' => $switchDetail['switchType'] == 1 ? 1 : 2,
                                'status' => $switchDetail['status'],
                                'comment' => $switchDetail['comment'],
                                'created_at' => $newMqttDataSwitchUnitHistory->created_at,
                            ];
                            MqttDataSwitchUnitHistoryDetail::query()->create($detail);
                        }
                    }
                }
            );

            //MqttDataSwitchUnitHistory::query()->insert($mqttDataSwitchUnitHistories);
        });
    }
}
