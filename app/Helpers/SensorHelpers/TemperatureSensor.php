<?php

if (!function_exists('getTemperatureSensorUpdate')) {
    function getTemperatureSensorUpdate($value)
    {
        $fishFeeder = [];

        if ($value < 24) {
            $fishFeeder = [1];
        } else if ($value >= 24 && $value <= 28) {
            return "No feed alarm";
        } else if ($value > 28) {
            $fishFeeder = [1, 2, 3, 4];
        }

        return implode(', ', $fishFeeder) . " fish feeder(s) will be activated";
    }
}
