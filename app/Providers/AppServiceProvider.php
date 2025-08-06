<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(InventarioService::class, function ($app) {
            return new InventarioService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Relation::morphMap([
            'parte' => \App\Models\Parte::class,
            'vehiculo' => \App\Models\Vehiculo::class,
        ]);
    }
}
