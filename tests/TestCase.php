<?php

namespace Albertvds\WpSync\Tests;

use Orchestra\Testbench\TestCase as PackageTestCase;
use Albertvds\WpSync\WpSyncServiceProvider;

class TestCase extends PackageTestCase
{
    protected function getPackageProviders($app): array
    {
        return [WpSyncServiceProvider::class];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('wp-sync.woo.secret', 'test-secret');
        $app['config']->set('wp-sync.wp.url',      'https://example.com');
        $app['config']->set('wp-sync.woo.url',      'https://example.com');
    }
}
