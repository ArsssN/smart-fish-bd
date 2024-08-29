<?php

if (!function_exists('getRainSensorUpdate')) {
    function getRainSensorUpdate($value): string
    {
        if ($value == 1) {
            return 'Not rainy';
        } else if ($value == 0) {
            return 'Rainy';
        } else {
            return 'No Condition Match';
        }
    }
}
