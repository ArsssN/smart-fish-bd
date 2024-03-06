<?php

if (!function_exists('getPHSensorUpdate')) {
    function getPHSensorUpdate($value)
    {
        if($value >= 6.5 && $value <= 8.5) {
            return "The pH level is standard";
        } else if($value > 8.5 & $value <= 9) {
            return "The pH level is unhealthy";
        } else if($value > 9 ) {
            return "The pH level is critical - RED LED will blink";
        } else if($value < 6.5) {
            return "The pH level is unhealthy - Yellow LED will blink";
        }
    }
}
