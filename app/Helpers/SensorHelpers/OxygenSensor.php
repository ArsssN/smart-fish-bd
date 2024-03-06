<?php

if (!function_exists('getOxygenSensorUpdate')) {
    function getOxygenSensorUpdate($value)
    {
        $sensorList = array();

        if ($value <= 2.5)
            $sensorList = [1, 3, 5, 6];
        else if ($value > 2.5 && $value <= 4)
            $sensorList = [2, 4, 6, 7];
        else if ($value > 4 && $value <= 5.5)
            $sensorList = [3, 7, 8];
        else if ($value > 5.5 && $value <= 7)
            $sensorList = [3, 5, 8];
        else
            return "No sensor will on, try between 0-7";

        return implode(', ', $sensorList) . " will on";
    }
}
