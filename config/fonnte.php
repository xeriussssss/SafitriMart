<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Fonnte WhatsApp Configuration
    |--------------------------------------------------------------------------
    | Token didapat dari: https://md.fonnte.com/new/setting.php
    | Admin phone: nomor WA yang menerima notifikasi (format: 628xxxxxxxxxx)
    */

    'token'       => env('FONNTE_TOKEN', ''),
    'admin_phone' => env('FONNTE_ADMIN_PHONE', ''),
];
