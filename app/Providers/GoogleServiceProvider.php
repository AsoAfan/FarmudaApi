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
            $client->setAccessType('offline');

            $accessToken = "ya29.a0AfB_byAOYbZHzXA8L46QE3YjLmsMG4idYg-EDdWMdXUZPrlVpE0IvthaYxq-UPtf8VJKfbusAkdg_DkadmmAujZYsFuhdZm1FKEI8nHRG4UGKpO_JO6wnSIjoimDdt0RLiMrUH03ecME-SzB-oqNpKtFKSCbgRL-UQaCgYKAWkSARESFQGOcNnCcYexcNgh3O8P54SC68LGxw0169";
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
