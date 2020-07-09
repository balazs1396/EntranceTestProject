<?php

namespace App\Providers;

use App\WS\ChannelConsumer;

use Illuminate\Support\ServiceProvider;

class ConsumerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ChannelConsumer::class, function () {
            return new ChannelConsumer(
                config('services.port_channel.location')
            );
        });
    }

    public function provides()
    {
        return [ChannelConsumer::class];
    }
}
