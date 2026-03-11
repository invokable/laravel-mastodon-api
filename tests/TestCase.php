<?php

namespace Tests;

use Illuminate\Foundation\Application;
use Revolution\Mastodon\Providers\MastodonServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            MastodonServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [];
    }

    /**
     * Define environment setup.
     *
     * @param  Application  $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        //
    }
}
