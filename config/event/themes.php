<?php

$dimensions = [
    'default' => [
        'width'  => 1062,
        'height' => 648,
    ],
];

return [
    'default' => [
        'name'      => 'Default',
        'demo'      => [
            'front' => '/assets/images/event/themes/default/front/demo.jpg',
            'back'  => '/assets/images/event/themes/default/back/demo.jpg',
        ],
        'dimension' => [
            'width'  => $dimensions['default']['width'],
            'height' => $dimensions['default']['height']
        ],
        'qr_code'   => [
            'size'   => 200,
            'format' => 'png',
        ],
        'front'     => [
            'background'       => [
                'position' => 'top-left',
                'x'        => 0,
                'y'        => 0,
                'color'    => '#ffffff',
                'image'    => public_path('uploads/event/tools/bg-default.jpg'),
            ],
            'qr_code'          => [
                'position' => 'bottom-right',
                'x'        => 20,
                'y'        => 20,
                'width'    => 150,
                'height'   => 150,
            ],
            'event_title'      => [
                'x'          => 20,
                'y'          => 20,
                'font'       => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 60,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
                'wrap_after' => 20, // wrap after 50 characters
            ],
            'event_start_date' => [
                'x'      => 20,
                'y'      => 90,
                'format' => 'd M, Y - h:ma',
                'font'   => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
            ],
            'event_end_date'   => [
                'x'      => 20,
                'y'      => 120,
                'format' => 'd M, Y - h:ma',
                'font'   => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
            ],
            'event_location'   => [
                'x'          => 20,
                'y'          => 150,
                'font'       => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
                'wrap_after' => 50, // wrap after 50 characters
            ],
            'invitee_name'     => [
                'x'          => $dimensions['default']['width'] - 20,
                'y'          => 20,
                'font'       => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 60,
                    'color'  => '#000',
                    'align'  => 'right',
                    'valign' => 'top',
                ],
                'wrap_after' => 18, // wrap after 15 characters
            ],
            'invitee_address'  => [
                'x'          => 20,
                'y'          => $dimensions['default']['height'] - 30 - 30 - 45,
                'font'       => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
                'wrap_after' => 50, // wrap after 50 characters
            ],
            'invitee_phone'    => [
                'x'    => 20,
                'y'    => $dimensions['default']['height'] - 30 - 42,
                'font' => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
            ],
            'invitee_email'    => [
                'x'    => 20,
                'y'    => $dimensions['default']['height'] - 45,
                'font' => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
            ],
        ],
        'back'     => [
            'background'       => [
                'position' => 'top-left',
                'x'        => 0,
                'y'        => 0,
                'color'    => '#ffffff',
                'image'    => public_path('uploads/event/tools/bg-default.jpg'),
            ],
            'qr_code'          => [
                'position' => 'bottom-right',
                'x'        => 20,
                'y'        => 20,
                'width'    => 150,
                'height'   => 150,
            ],
            'event_title'      => [
                'x'          => 20,
                'y'          => 20,
                'font'       => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 60,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
                'wrap_after' => 20, // wrap after 50 characters
            ],
            'event_start_date' => [
                'x'      => 20,
                'y'      => 90,
                'format' => 'd M, Y - h:ma',
                'font'   => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
            ],
            'event_end_date'   => [
                'x'      => 20,
                'y'      => 120,
                'format' => 'd M, Y - h:ma',
                'font'   => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
            ],
            'event_location'   => [
                'x'          => 20,
                'y'          => 150,
                'font'       => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
                'wrap_after' => 50, // wrap after 50 characters
            ],
            'invitee_name'     => [
                'x'          => $dimensions['default']['width'] - 20,
                'y'          => 20,
                'font'       => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 60,
                    'color'  => '#000',
                    'align'  => 'right',
                    'valign' => 'top',
                ],
                'wrap_after' => 18, // wrap after 15 characters
            ],
            'invitee_address'  => [
                'x'          => 20,
                'y'          => $dimensions['default']['height'] - 30 - 30 - 45,
                'font'       => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
                'wrap_after' => 50, // wrap after 50 characters
            ],
            'invitee_phone'    => [
                'x'    => 20,
                'y'    => $dimensions['default']['height'] - 30 - 42,
                'font' => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
            ],
            'invitee_email'    => [
                'x'    => 20,
                'y'    => $dimensions['default']['height'] - 45,
                'font' => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
            ],
        ],
    ],
    'default 2' => [
        'name'      => 'Default',
        'demo'      => [
            'front' => '/assets/images/event/themes/default/front/demo.jpg',
            'back'  => '/assets/images/event/themes/default/back/demo.jpg',
        ],
        'dimension' => [
            'width'  => $dimensions['default']['width'],
            'height' => $dimensions['default']['height']
        ],
        'qr_code'   => [
            'size'   => 200,
            'format' => 'png',
        ],
        'front'     => [
            'background'       => [
                'position' => 'top-left',
                'x'        => 0,
                'y'        => 0,
                'color'    => '#ffffff',
                'image'    => public_path('uploads/event/tools/bg-default.jpg'),
            ],
            'qr_code'          => [
                'position' => 'bottom-right',
                'x'        => 20,
                'y'        => 20,
                'width'    => 150,
                'height'   => 150,
            ],
            'event_title'      => [
                'x'          => 20,
                'y'          => 20,
                'font'       => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 60,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
                'wrap_after' => 20, // wrap after 50 characters
            ],
            'event_start_date' => [
                'x'      => 20,
                'y'      => 90,
                'format' => 'd M, Y - h:ma',
                'font'   => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
            ],
            'event_end_date'   => [
                'x'      => 20,
                'y'      => 120,
                'format' => 'd M, Y - h:ma',
                'font'   => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
            ],
            'event_location'   => [
                'x'          => 20,
                'y'          => 150,
                'font'       => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
                'wrap_after' => 50, // wrap after 50 characters
            ],
            'invitee_name'     => [
                'x'          => $dimensions['default']['width'] - 20,
                'y'          => 20,
                'font'       => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 60,
                    'color'  => '#000',
                    'align'  => 'right',
                    'valign' => 'top',
                ],
                'wrap_after' => 18, // wrap after 15 characters
            ],
            'invitee_address'  => [
                'x'          => 20,
                'y'          => $dimensions['default']['height'] - 30 - 30 - 45,
                'font'       => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
                'wrap_after' => 50, // wrap after 50 characters
            ],
            'invitee_phone'    => [
                'x'    => 20,
                'y'    => $dimensions['default']['height'] - 30 - 42,
                'font' => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
            ],
            'invitee_email'    => [
                'x'    => 20,
                'y'    => $dimensions['default']['height'] - 45,
                'font' => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
            ],
        ],
        'back'     => [
            'background'       => [
                'position' => 'top-left',
                'x'        => 0,
                'y'        => 0,
                'color'    => '#ffffff',
                'image'    => public_path('uploads/event/tools/bg-default.jpg'),
            ],
            'qr_code'          => [
                'position' => 'bottom-right',
                'x'        => 20,
                'y'        => 20,
                'width'    => 150,
                'height'   => 150,
            ],
            'event_title'      => [
                'x'          => 20,
                'y'          => 20,
                'font'       => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 60,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
                'wrap_after' => 20, // wrap after 50 characters
            ],
            'event_start_date' => [
                'x'      => 20,
                'y'      => 90,
                'format' => 'd M, Y - h:ma',
                'font'   => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
            ],
            'event_end_date'   => [
                'x'      => 20,
                'y'      => 120,
                'format' => 'd M, Y - h:ma',
                'font'   => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
            ],
            'event_location'   => [
                'x'          => 20,
                'y'          => 150,
                'font'       => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
                'wrap_after' => 50, // wrap after 50 characters
            ],
            'invitee_name'     => [
                'x'          => $dimensions['default']['width'] - 20,
                'y'          => 20,
                'font'       => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 60,
                    'color'  => '#000',
                    'align'  => 'right',
                    'valign' => 'top',
                ],
                'wrap_after' => 18, // wrap after 15 characters
            ],
            'invitee_address'  => [
                'x'          => 20,
                'y'          => $dimensions['default']['height'] - 30 - 30 - 45,
                'font'       => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
                'wrap_after' => 50, // wrap after 50 characters
            ],
            'invitee_phone'    => [
                'x'    => 20,
                'y'    => $dimensions['default']['height'] - 30 - 42,
                'font' => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
            ],
            'invitee_email'    => [
                'x'    => 20,
                'y'    => $dimensions['default']['height'] - 45,
                'font' => [
                    'file'   => public_path('fonts/Roboto/Roboto-Regular.ttf'),
                    'size'   => 25,
                    'color'  => '#000',
                    'align'  => 'left',
                    'valign' => 'top',
                ],
            ],
        ],
    ],
];
