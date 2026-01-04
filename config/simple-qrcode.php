<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Konfigurasi Simple QrCode
    |--------------------------------------------------------------------------
    | Konfigurasi ini memaksa QR Code menggunakan GD library 
    | alih-alih Imagick yang menyebabkan error
    */

    'default' => [
        'format' => 'png',
        'size' => 300,
        'margin' => 2,
        'errorCorrection' => 'M',
        'round_block_size' => true,
        'bgcolor' => false,
        'color' => false,
        'writer' => 'png', // Paksa menggunakan PNG writer yang pakai GD
        'writer_options' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Writer yang Tersedia
    |--------------------------------------------------------------------------
    | Writer yang bisa dipakai: 'png', 'svg', 'eps', 'pdf'
    | PNG writer menggunakan GD library bukan Imagick
    */
    'writer' => 'png',

    /*
    |--------------------------------------------------------------------------
    | Pengaturan Backend
    |--------------------------------------------------------------------------
    | Paksa menggunakan GD backend
    */
    'backend' => 'gd',

    /*
    |--------------------------------------------------------------------------
    | Path Configuration
    |--------------------------------------------------------------------------
    */
    'storage_path' => 'storage/qrcodes',
    'public_path' => 'storage/qrcodes',

    /*
    |--------------------------------------------------------------------------
    | Fallback Options
    |--------------------------------------------------------------------------
    */
    'fallback_format' => 'svg', // Jika PNG gagal, gunakan SVG
    'enable_logging' => true,    // Enable error logging
];