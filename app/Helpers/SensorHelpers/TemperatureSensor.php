<?php

if (!function_exists('getTemperatureSensorUpdate')) {
    function getTemperatureSensorUpdate($value)
    {
        $fishFeeder = [];

        if ($value < 24) {
            $fishFeeder = '1, 0, 0, 0, 0, 0, 0, 0, 0, 0,0,0';
        } else if ($value >= 24 && $value <= 28) {
            return 'No feed alarm';
        } else if ($value > 28) {
            $fishFeeder = '1, 2, 3, 4, 0, 0, 0, 0, 0, 0, 0, 0';
        }

        return $fishFeeder;
    }
}
