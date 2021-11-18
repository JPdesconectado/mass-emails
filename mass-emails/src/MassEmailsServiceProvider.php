<?php

namespace Koisystems\MassEmails;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Koisystems\MassEmails\Http\Livewire\MassEmailForm;
use Koisystems\MassEmails\View\Components\Filter;
use Livewire\Livewire;

class MassEmailsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'mass-emails');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'mass-emails');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->registerRoutes();
        Livewire::component('mass-email-form', MassEmailForm::class);
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => config('mass-emails.prefix'),
            'middleware' => config('mass-emails.middleware'),
        ];
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/mass-emails.php', 'mass-emails');

        // Register the service the package provides.
        $this->app->singleton('mass-emails', function ($app) {
            return new MassEmails;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['mass-emails'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/mass-emails.php' => config_path('mass-emails.php'),
        ], 'mass-emails.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/koisystems'),
        ], 'mass-emails.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/koisystems'),
        ], 'mass-emails.views');*/


        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/koisystems'),
        ]);

        // Registering package commands.
        // $this->commands([]);
    }
}
