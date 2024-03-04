<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Upload dir
    |--------------------------------------------------------------------------
    |
    | The dir where to store the images (relative from public).
    |
    */
    'dir'   => ['storage', 'uploads'],

    /*
    |--------------------------------------------------------------------------
    | Filesystem disks (Flysytem)
    |--------------------------------------------------------------------------
    |
    | Define an array of Filesystem disks, which use Flysystem.
    | You can set extra options, example:
    |
    | 'my-disk' => [
    |        'URL' => url('to/disk'),
    |        'alias' => 'Local storage',
    |    ]
    */
    'disks' => [
        // 'uploads'
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes group config
    |--------------------------------------------------------------------------
    |
    | The default group settings for the elFinder routes.
    |
    */

    'route' => [
        'prefix'     => config('backpack.base.route_prefix', 'admin') . '/elfinder',
        'middleware' => ['web', config('backpack.base.middleware_key', 'admin')], //Set to null to disable middleware filter
    ],

    /*
    |--------------------------------------------------------------------------
    | Access filter
    |--------------------------------------------------------------------------
    |
    | Filter callback to check the files
    |
    */

    'access' => 'Barryvdh\Elfinder\Elfinder::checkAccess',

    /*
    |--------------------------------------------------------------------------
    | Roots
    |--------------------------------------------------------------------------
    |
    | By default, the roots file is LocalFileSystem, with the above public dir.
    | If you want custom options, you can set your own roots below.
    |
    */

    'roots' => null,

    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    |
    | These options are merged, together with 'roots' and passed to the Connector.
    | See https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options-2.1
    |
    */

    'options' => [],

    /*
    |--------------------------------------------------------------------------
    | Themes
    |--------------------------------------------------------------------------
    |
    | Customize file manager theme here.
    | Default value: 'backpack.default'
    | See:
    |   Material Theme: https://github.com/RobiNN1/elFinder-Material-Theme
    |   DarkSlim Theme: https://github.com/johnfort/elFinder.themes
    |
    */

    'default' => env('FILE_MANAGER_THEME', 'backpack.default'),
    'themes'  => [
        'backpack'    => [
            'default'  => [
                'css' => 'packages/backpack/filemanager/themes/Backpack/elfinder.backpack.theme.css',
                'js'  => '',
            ],
            'elfinder' => [
                'css' => 'packages/barryvdh/elfinder/css/theme.css',
                'js'  => '',
            ],
        ],
        'dark-slim'   => [
            'default' => [
                'css' => 'packages/backpack/filemanager/themes/DarkSlim/latest/css/elfinder.theme.min.css',
                'js'  => '',
            ],
        ],
        'libre-icons' => [
            'bootstrap' => [
                'css' => 'packages/backpack/filemanager/themes/LibreICONS/css/theme-bootstrap-libreicons-svg.css',
                'js'  => '',
            ],
        ],
        'material'    => [
            'default' => [
                'css' => 'packages/backpack/filemanager/themes/Material/css/theme.min.css',
                'js'  => '',
            ],
            'gray'    => [
                'css' => 'packages/backpack/filemanager/themes/Material/css/theme-gray.min.css',
                'js'  => '',
            ],
            'light'   => [
                'css' => 'packages/backpack/filemanager/themes/Material/css/theme-light.min.css',
                'js'  => '',
            ],
        ],
        'moono'       => [
            'default' => [
                'css' => 'packages/backpack/filemanager/themes/Moono/css/theme.css',
                'js'  => '',
            ],
        ],
        'windows10'   => [
            'default' => [
                'css' => 'packages/backpack/filemanager/themes/Windows10/css/theme.css',
                'js'  => '',
            ],
        ],
    ],

    'middleware' => Backpack\FileManager\Middleware\FileManagerMiddleware::class,
];
