<?php

return [
    'models' => [
        'user' => null,
    ],
    'layout' => 'x-app-layout',
    'media_collection' => 'support_attachments',
    'route-name' => '/support',
    'user-page-livewire-view' => 'laravel-support-center::livewire.user-page',
    'user-page-layout' => 'layouts.app',

    'admin-route-name' => '/support/admin',
    'admin-page-livewire-view' => 'laravel-support-center::livewire.admin-page',
    'admin-page-layout' => 'layouts.admin',
    'admin-page-pagination' => 15,

];
