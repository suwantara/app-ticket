<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Server Key
    |--------------------------------------------------------------------------
    |
    | Server key digunakan untuk mengakses Midtrans API dari server.
    | Dapatkan key dari Dashboard Midtrans > Settings > Access Keys
    |
    */
    'server_key' => env('MIDTRANS_SERVER_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Midtrans Client Key
    |--------------------------------------------------------------------------
    |
    | Client key digunakan untuk Snap.js di frontend.
    | Dapatkan key dari Dashboard Midtrans > Settings > Access Keys
    |
    */
    'client_key' => env('MIDTRANS_CLIENT_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Midtrans Environment
    |--------------------------------------------------------------------------
    |
    | Set true untuk Production, false untuk Sandbox.
    |
    */
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    /*
    |--------------------------------------------------------------------------
    | Sanitize Data
    |--------------------------------------------------------------------------
    |
    | Midtrans akan melakukan sanitasi data sebelum dikirim.
    |
    */
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),

    /*
    |--------------------------------------------------------------------------
    | 3DS Transaction
    |--------------------------------------------------------------------------
    |
    | Aktifkan 3DS untuk keamanan transaksi kartu kredit.
    |
    */
    'is_3ds' => env('MIDTRANS_IS_3DS', true),

    /*
    |--------------------------------------------------------------------------
    | Snap API URL
    |--------------------------------------------------------------------------
    |
    | URL untuk Midtrans Snap API.
    |
    */
    'snap_url' => env('MIDTRANS_IS_PRODUCTION', false)
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js',
];
