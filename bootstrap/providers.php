<?php

use App\Providers\AppServiceProvider;

return [
    AppServiceProvider::class,
    Barryvdh\DomPDF\ServiceProvider::class,
];

return [
    // ... providers di atas

    'aliases' => [
        'PDF' => Barryvdh\DomPDF\Facade\Pdf::class,
    ],
];
