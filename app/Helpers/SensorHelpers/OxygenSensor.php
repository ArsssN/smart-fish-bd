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
        else if ($value < 7)
            $sensorList = [0, 1, 0, 1, 0, 1, 1, 0, 0, 0, 0, 0];
        else $sensorList = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        /*else
            return "Invalid DO level. Please enter a value between 0 and 8.";*/

        return $sensorList;
    }
}

if (!function_exists('convertDOValue')) {
    function convertDOValue($doValue, $currentTime = null)
    {
        // if no $currentTime is provided, use the current time
        if ($currentTime === null) {
            $currentTime = date('H:i');
        }

        // Define the conversion values based on time ranges
        $conversionValues = [
            '5:00-6:00' => 4.2,
            '6:00-7:00' => 4.1,
            '7:00-8:00' => 4.4,
            '8:00-9:00' => 5.1,
            '9:00-10:00' => 6.2,
            '10:00-11:00' => 6.8,
            '11:00-12:00' => 6.5,
            '12:00-13:00' => 6.1,
            '13:00-14:00' => 5.5,
            '14:00-15:00' => 5.2,
            '15:00-16:00' => 5.0,
            '16:00-17:00' => 4.8,
            '17:00-18:00' => 4.5,
            '18:00-19:00' => 4.0,
            '19:00-20:00' => 3.5,
            '20:00-21:00' => 2.9,
            '21:00-22:00' => 3.4,
            '22:00-23:00' => 4.6,
            '23:00-24:00' => 4.7,
            '00:00-01:00' => 4.1,
            '01:00-02:00' => 4.6,
            '02:00-03:00' => 6.1,
            '03:00-04:00' => 4.6,
            '04:00-05:00' => 4.3,
        ];

        // Extract the hour and minute from currentTime
        $hour = (int)date('H', strtotime($currentTime));
        $minute = (int)date('i', strtotime($currentTime));

        // Determine the time range key
        $timeRange = sprintf('%02d:00-%02d:00', $hour, $hour + 1);

        // Convert DO value based on the time range
        if ($doValue < 1.5) {
            if (array_key_exists($timeRange, $conversionValues)) {
                return $conversionValues[$timeRange];
            } else {
                // If time range not found, return original DO value
                return $doValue;
            }
        }

        // Return the original DO value if not less than 1.5
        return $doValue;
    }
}
