<?php

if (!function_exists('getOxygenSensorUpdate')) {
    function getOxygenSensorUpdate($value)
    {
        $sensorList = array();

        if ($value <= 2.5)
            $sensorList = "1, 0, 3, 0, 5, 6, 0, 0, 0, 0, 0, 0";
        else if ($value > 2.5 && $value <= 4)
            $sensorList = "0, 2, 0, 4, 0, 6, 7, 0, 0, 0, 0, 0";
        else if ($value > 4 && $value <= 5.5)
            $sensorList = "0, 0, 3, 0, 0, 0, 7, 8, 0, 0, 0, 0";
        else if ($value > 5.5 && $value <= 7)
            $sensorList = "0, 0, 3, 0, 5, 0, 0, 8, 0, 0, 0, 0";
        else
            return "No sensor will on, try between 0-7";

        return $sensorList;
    }
}
