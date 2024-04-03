<?php

namespace App\Http\Controllers;

use App\Models\MqttData;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MqttCommandController extends Controller
{
    /**
     * @param $type string - unit type (sensor, switch, etc)
     * @param $responseMessage object - response message from mqtt
     * @return string
     */
    public static function saveMqttData(string $type, object $responseMessage): string
    {
        $remoteNames = collect($responseMessage->data)->keys()->toArray();

        $serialNumber = hexdec($responseMessage->addr);
        $project      = Project::query()
            ->where('gateway_serial_number', $responseMessage->gw_id)
            ->with('ponds', function ($query) use ($type, $serialNumber, $remoteNames) {
                $query->whereHas("{$type}Units", function ($query) use ($type, $serialNumber, $remoteNames) {
                    $query->where('serial_number', $serialNumber)
                        ->whereHas("{$type}Types", function ($query) use ($remoteNames) {
                            $query->whereIn('remote_name', $remoteNames);
                        });
                })->with("{$type}Units.{$type}Types");
            })
            ->firstOrFail();

        $projectID = $project->id;
        $mqttData  = MqttData::query()->create([
            'type'       => $type,
            'project_id' => $projectID,
            'data'       => json_encode($responseMessage),
        ]);
        $project->ponds->each(function ($pond) use ($type, $responseMessage, $mqttData) {
            $pondID    = $pond->id;
            $typeUnits = "{$type}Units";
            $pond->$typeUnits->each(function ($typeUnit) use ($type, $responseMessage, $mqttData, $pondID) {
                $typeUnitID = $typeUnit->id;
                $typeTypes  = "{$type}Types";
                $typeUnit->$typeTypes->each(function ($typeType) use ($type, $responseMessage, $mqttData, $pondID, $typeUnitID) {
                    $typeTypeID = $typeType->id;
                    $remoteName = $typeType->remote_name;
                    $value      = $responseMessage->data->$remoteName;

                    $typeName         = Str::replace(' ', '', $typeType->name);
                    $helperMethodName = "get{$typeName}Update";

                    if (function_exists($helperMethodName)) {
                        $type_message = ($helperMethodName(
                            $value,
                        ));

                        // if array
                        if (is_array($type_message)) {
                            $type_message = implode(', ', $type_message);
                        }
                    } else {
                        $type_message = "No helper method found for $type: {$typeType->name}";
                    }

                    $mqttData->histories()->create([
                        'pond_id'         => $pondID,
                        "{$type}_unit_id" => $typeUnitID,
                        "{$type}_type_id" => $typeTypeID,
                        'value'           => $value,
                        'type'            => $type,
                        'message'         => $type_message,
                    ]);
                });

                die();
            });
        });

        return '0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1';
    }
}
