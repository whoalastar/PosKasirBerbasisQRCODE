<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Set timezone dan locale untuk Carbon
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function register()
    {
        //
    }
}