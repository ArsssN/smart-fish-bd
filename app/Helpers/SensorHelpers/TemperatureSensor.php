<?php

if (!function_exists('getTemperatureSensorUpdate')) {
    function getTemperatureSensorUpdate($value)
    {
        $fishFeeder = [];

        /*if ($value < 24) {
            // $fishFeeder = '1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0';
            $fishFeeder = [1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        } else if ($value >= 24 && $value <= 28) {
            return 'No feed alarm';
        } else if ($value > 28) {
            // $fishFeeder = '1, 2, 3, 4, 0, 0, 0, 0, 0, 0, 0, 0';
            $fishFeeder = [1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0];
        }*/

        if ($value < 20 || $value > 38) {
            return 'No Feed';
        }elseif ($value >= 20 || $value <= 25) {
            return 'Below';
        }elseif ($value > 25 || $value <= 32) {
            return 'Optimum';
        }elseif ($value > 32 || $value <= 38) {
            return 'High';
        }

        return $fishFeeder;
    }
}
