<?php

namespace App\Providers;

use App\Http\Resources\CardCollection;
use App\Http\Resources\CardResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        CardResource::withoutWrapping();
        CardCollection::withoutWrapping();
    }
}
