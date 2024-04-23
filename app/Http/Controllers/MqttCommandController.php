<?php

namespace App\Http\Controllers;

use App\Models\MqttData;
use App\Models\MqttDataSwitchUnitHistory;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;

class MqttCommandController extends Controller
{
    /**
     * @var MqttData $mqttData - mqtt data
     */
    public static MqttData $mqttData;

    /**
     * @param $type            string - unit type (sensor, switch, etc)
     * @param $responseMessage object - response message from mqtt
     * @param $topic           string - mqtt topic
     *
     * @return string
     */
    public static function saveMqttData(string $type, object $responseMessage, string $topic): string
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

        $project = $typeUnit->ponds->firstOrFail()->project;

        $switchState = array_fill(0, 12, 0);

        $projectID = $project->id;
        $mqttData = MqttData::query()->create([
            'type' => $type,
            'project_id' => $projectID,
            'data' => json_encode($responseMessage),
            'publish_topic' => $topic,
        ]);
        self::$mqttData = $mqttData;

        $typeUnit->{$type . 'Types'}
            ->each(
                function ($typeType)
                use ($typeUnit, $type, $responseMessage, $mqttData, &$switchState) {
                    self::saveMqttDataHistory($typeType, $typeUnit, $type, $responseMessage, $mqttData, $switchState);
                }
            );

        self::changeSwitchStateOfSensorUnit($mqttData, $typeUnit->ponds, $switchState);

        return implode(', ', $switchState);
    }

    /**
     * Save mqtt data history
     *
     * @param $typeType
     * @param $typeUnit
     * @param $type
     * @param $responseMessage
     * @param $mqttData
     * @param $switchState
     *
     * @return void
     */
    private static function saveMqttDataHistory($typeType, $typeUnit, $type, $responseMessage, $mqttData, &$switchState): void
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
            if (is_array($type_message) && $typeType->can_switch_sensor) {
                $switchState = mergeSwitchArray(
                    $type_message,
                    $switchState
                );

                $type_message = implode(', ', $type_message);
            }
        } else {
            $type_message = "No helper method found for $type: {$typeType->name}";
        }

        $typeUnit->ponds->each(function ($pond) use ($type, $mqttData, $typeUnitID, $typeTypeID, $value, $type_message) {
            $pondID = $pond->id;

            $mqttData->histories()->create([
                'pond_id' => $pondID,
                "{$type}_unit_id" => $typeUnitID,
                "{$type}_type_id" => $typeTypeID,
                'value' => $value,
                'type' => $type,
                'message' => $type_message,
            ]);
        });
    }

    /**
     * @param $mqttData
     * @param $ponds
     * @param $switchState
     *
     * @return void
     */
    private static function changeSwitchStateOfSensorUnit($mqttData, $ponds, $switchState): void
    {
        $ponds->each(function ($pond) use ($mqttData, $switchState) {
            $mqttDataSwitchUnitHistories = [];
            $pond->switchUnits->each(function ($switchUnit) use ($mqttData, $switchState, &$mqttDataSwitchUnitHistories) {

                $switches = collect($switchUnit->switches ?? '[]');
                $switches->map(function ($switch, $index) use ($switchUnit, $mqttData, $switchState) {
                    $switch['status'] = $switchState[$index]
                        ? 'on'
                        : 'off';

                    return $switch;
                });

                $switchUnit->switches = $switches->toArray();
                $switchUnit->save();

                $mqttDataSwitchUnitHistories[] = [
                    'mqtt_data_id' => $mqttData->id,
                    'pond_id' => $switchUnit->pivot->pond_id,
                    'switch_unit_id' => $switchUnit->id,
                    'switches' => json_encode($switches),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            });

            MqttDataSwitchUnitHistory::query()->insert($mqttDataSwitchUnitHistories);
        });
    }
}
