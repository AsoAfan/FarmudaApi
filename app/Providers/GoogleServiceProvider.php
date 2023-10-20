<?php

namespace App\Providers;

use Google_Client;
use Google_Service_Drive;
use Illuminate\Support\ServiceProvider;

class GoogleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Google_Client::class, function () {
            $client = new Google_Client();
            $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
            $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
            $client->setRedirectUri(env('GOOGLE_DRIVE_REDIRECT_URI'));
            $client->setAccessType('online');

            $accessToken = "a29.a0AfB_byBwOUJBQEY_IElACT03Mv11LK4RA0t9vBU9TxwQdPfmB1e4N8lfxQ0qZQJPWMVblbUjT430uGACkaa_m-1fVZxE9upiiJckU7X5aS1AnSKSCR_2DTRSLPCfHlbi5yd9DMUrZrATWi4X6q73XhcWlAUSuhOm5qAUaCgYKAS0SARESFQGOcNnCtOb44OTrX7vj_BGelA-dSw0171";
// Obtain the access token from OAuth (you will have this after user consent)
            $client->setAccessToken($accessToken);
            return $client;
        });

        $this->app->bind(Google_Service_Drive::class, function ($app) {
            $client = $app->make(Google_Client::class);
            return new Google_Service_Drive($client);
        });
    }


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
