<?php

return [
    'prefix' => env('APP_ENV', 'production') === 'production'
        ? getCurrentApiVersion()
        : 'api/' . getCurrentApiVersion()
];
