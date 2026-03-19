<?php

namespace Albertvds\WpSync;

use Illuminate\Support\ServiceProvider;
use Albertvds\WpSync\Http\WpClient;
use Albertvds\WpSync\Http\WooClient;
use Albertvds\WpSync\Commands\WpSyncCommand;
use Albertvds\WpSync\Commands\WooSyncCommand;

class WpSyncServiceProvider extends ServiceProvider
{
    /**
     * Register package bindings into the service container.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/wp-sync.php', 'wp-sync');

        $this->app->singleton(WpClient::class, fn ($app) => new WpClient(
            url:      config('wp-sync.wp.url'),
            user:     config('wp-sync.wp.user'),
            password: config('wp-sync.wp.app_password'),
        ));

        $this->app->singleton(WooClient::class, fn ($app) => new WooClient(
            url:    config('wp-sync.woo.url'),
            key:    config('wp-sync.woo.key'),
            secret: config('wp-sync.woo.secret'),
        ));
    }

    /**
     * Boot package services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/webhook.php');

        $this->publishes([
            __DIR__.'/../config/wp-sync.php' => config_path('wp-sync.php'),
        ], 'wp-sync-config');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'wp-sync-migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                WpSyncCommand::class,
                WooSyncCommand::class,
            ]);
        }
    }
}
