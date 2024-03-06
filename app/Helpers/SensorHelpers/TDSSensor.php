<?php

if (!function_exists('getTDSSensorUpdate')) {
    function getTDSSensorUpdate($value)
    {
        if($value >= 250 && $value <= 400) {
            return "The TDS level is standard";
        } else if($value > 400 || $value < 250) {
            return "The TDS level is unhealthy";
        }
    }
}
