<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use function \App\Http\Requests\UpdatePassword\checkPassword as checkPassword;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // TODO передать метод класса
        //\Validator::extend('password', checkPassword());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
