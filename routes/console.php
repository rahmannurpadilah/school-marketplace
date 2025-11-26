<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

    $wa = preg_replace('/[^0-9]/', '', $toko->kontak_toko ?? '');
    if ($wa && str_starts_with($wa, '0')) {
        $wa = '62' . substr($wa, 1);
    }
