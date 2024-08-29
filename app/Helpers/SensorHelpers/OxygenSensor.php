<?php

if (!function_exists('getOxygenSensorUpdate')) {
    function getOxygenSensorUpdate($value): array|string
    {
        $sensorList = array();

        if ($value <= 3)
            $sensorList = [1, 1, 1, 1, 1, 0, 1, 0, 0, 0, 0, 0];
        else if ($value <= 4.5)
            $sensorList = [0, 1, 1, 1, 1, 0, 1, 0, 0, 0, 0, 0];
        else if ($value <= 6)
            $sensorList = [1, 1, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0];
        else if ($value > 6 && $value < 7)
            $sensorList = [0, 1, 0, 1, 0, 1, 1, 0, 0, 0, 0, 0];
        else if ($value >= 7)
            $sensorList = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        /*else
            return "Invalid DO level. Please enter a value between 0 and 8.";*/

        return $sensorList;
    }
}
