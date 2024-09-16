<?php

if (!function_exists('getPHSensorUpdate')) {
    function getPHSensorUpdate($value): float|int|string
    {
        if ($value < 6.5) {
            return "The pH level is unhealthy - Yellow LED will blink";
        } elseif ($value >= 6.5 && $value <= 8.5) {
            return "The pH level is standard";
        } elseif ($value > 8.5 && $value <= 9) {
            return "The pH level is unhealthy";
        } else {
            return "The pH level is critical - RED LED will blink.";
        }
    }
}
