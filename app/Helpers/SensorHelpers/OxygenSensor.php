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

        // Extract the hour and minute from currentTime
        $hour = (int)date('H', strtotime($currentTime));
        $minute = (int)date('i', strtotime($currentTime));

        // Define the conversion values based on time ranges
        $conversionValues = [
            '05:01-05:20' => 2.80,
            '05:21-05:40' => 2.81,
            '05:41-06:00' => 2.82,
            '06:01-06:20' => 2.85,
            '06:21-06:40' => 3.18,
            '06:41-07:00' => 3.48,
            '07:01-07:20' => 3.76,
            '07:21-07:40' => 4.23,
            '07:41-08:00' => 4.64,
            '08:01-08:20' => 4.97,
            '08:21-08:40' => 5.32,
            '08:41-09:00' => 5.61,
            '09:01-09:20' => 5.42,
            '09:21-09:40' => 5.11,
            '09:41-10:00' => 4.85,
            '10:01-10:20' => 4.74,
            '10:21-10:40' => 4.47,
            '10:41-11:00' => 4.39,
            '11:01-11:20' => 4.62,
            '11:21-11:40' => 4.88,
            '11:41-12:00' => 5.19,

            '12:01-12:20' => 5.19,
            '12:21-12:40' => 5.63,
            '12:41-13:00' => 5.92,
            '13:01-13:20' => 7.01,
            '13:21-13:40' => 6.82,
            '13:41-14:00' => 6.49,
            '14:01-14:20' => 6.23,
            '14:21-14:40' => 5.93,
            '14:41-15:00' => 5.61,
            '15:01-15:20' => 5.14,
            '15:21-15:40' => 4.51,
            '15:41-16:00' => 4.06,
            '16:01-16:20' => 3.36,
            '16:21-16:40' => 2.99,
            '16:41-17:00' => 3.17,
            '17:01-17:20' => 3.53,
            '17:21-17:40' => 2.91,
            '17:41-18:00' => 2.85,
            '18:01-18:20' => 2.93,
            '18:21-18:40' => 3.05,
            '18:41-19:00' => 3.24,

            '19:01-19:20' => 3.24,
            '19:21-19:40' => 3.32,
            '19:41-20:00' => 3.56,
            '20:01-20:20' => 3.61,
            '20:21-20:40' => 3.77,
            '20:41-21:00' => 3.86,
            '21:01-21:20' => 4.05,
            '21:21-21:40' => 4.21,
            '21:41-22:00' => 4.57,
            '22:01-22:20' => 4.64,
            '22:21-22:40' => 4.83,
            '22:41-23:00' => 5.01,
            '23:01-23:20' => 5.19,
            '23:21-23:40' => 5.43,
            '23:41-00:00' => 5.65,
            '00:01-00:20' => 5.82,
            '00:21-00:40' => 6.01,
            '00:41-01:00' => 6.12,
            '01:01-01:20' => 6.21,
            '01:21-01:40' => 6.14,
            '01:41-02:00' => 6.05,

            '02:01-02:20' => 6.05,
            '02:21-02:40' => 5.83,
            '02:41-03:00' => 5.67,
            '03:01-03:20' => 5.34,
            '03:21-03:40' => 4.91,
            '03:41-04:00' => 4.53,
            '04:01-04:20' => 4.08,
            '04:21-04:40' => 3.65,
            '04:41-05:00' => 3.23,
        ];
        // Datetime range for one third hours or every 20 minutes
        if ($minute >= 0 && $minute < 20) {
            $timeRange = sprintf('%02d:01-%02d:20', $hour, $hour);
        } else if ($minute >= 20 && $minute < 40) {
            $timeRange = sprintf('%02d:21-%02d:40', $hour, $hour);
        } else if ($minute >= 40 && $minute < 60) {
            $timeRange = sprintf('%02d:41-%02d:00', $hour, $hour + 1);
        } else {
            // If minute is not within 0-59, return the original DO value
            return $doValue;
        }

        /*// Determine the time range key
        $timeRange = sprintf('%02d:00-%02d:00', $hour, $hour + 1);
        $conversionValues = [
            '05:00-06:00' => 4.2,
            '06:00-07:00' => 4.1,
            '07:00-08:00' => 4.4,
            '08:00-09:00' => 5.1,
            '09:00-10:00' => 6.2,
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
        ];*/

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
