<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class LineBotServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(LINEBot::class, function ($app) {
            $config = $app->make('config');
            $client = new CurlHTTPClient($config['line']['channel_access_token']);
            return new LINEBot($client, ['channelSecret' => $config['line']['channel_secret']]);
        });
    }
}
