<?php

return [
    'mail-sender' => env('APP_CONTACT'),
    'models' => [
        'user' => null,
    ],
    'route' => [
        'prefix' => '/support',
        'name' => 'support-center.user-page',
    ],
    'media_collection' => 'support_attachments',
    'user-page-livewire-view' => 'laravel-support-center::livewire.user-page',
    'user-page-layout' => 'layouts.app',

    'admin-page-livewire-view' => 'laravel-support-center::livewire.admin-page',
    'admin-page-layout' => 'layouts.admin',
    'admin-page-pagination' => 15,

    'emails' => [
        'user' => [
            'confirmation-message' => [
                'subject' => 'Mensaje recibido',
                'mail_template' => 'laravel-support-center::emails.user-confirmation'
            ]
        ],
        'admin' => [
            'confirmation-message' => [
                'subject' => 'Mensaje recibido',
                'mail_template' => 'laravel-support-center::emails.user-confirmation'
            ]
        ]
    ]

];
