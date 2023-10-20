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

            $accessToken = "ya29.a0AfB_byBdpPVUfo70h1e-8nuFve0gt_VSASN9j4TNkMPrW-oeiYyaQ2APyEbISN9-xG35W_c7mqHL7lExZ0-enQDN_rI6KnvZlkZk2Xlsy9pziu153UdCEu8p9fE4NB79I3KVW0C5mtsBLUBp66M8RGb90WUDpxvsHWkaCgYKAbUSARESFQGOcNnCDhvWwz8Im6gmmb0gPPAyBA0170";
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
