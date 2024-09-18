<?php

if (!function_exists('getPHSensorUpdate')) {
    function getPHSensorUpdate($value): float|int|string
    {
        if ($value < 7) {
            return 'The pH level is unhealthy - Yellow LED will blink';
        } elseif ($value <= 8) {
            return 'The pH level is standard';
        } elseif ($value <= 9) {
            return 'The pH level is unhealthy';
        } else {
            return 'The pH level is critical - RED LED will blink.';
        }
    }
}
