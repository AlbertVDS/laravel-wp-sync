<?php

use Illuminate\Support\Facades\Route;
use Albertvds\WpSync\Http\WebhookController;

Route::post(
    config('wp-sync.webhook_path', 'woo/webhook'),
    WebhookController::class
)->name('wp-sync.webhook');
