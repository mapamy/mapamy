<?php

namespace App;

use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Provider\Instagram;

class OAuth
{
    public static function getGoogleProvider()
    {
        return new Google([
            'clientId' => $_ENV['GOOGLE_CLIENT_ID'],
            'clientSecret' => $_ENV['GOOGLE_CLIENT_SECRET'],
            'redirectUri' => $_ENV['GOOGLE_REDIRECT_URI'],
        ]);
    }

    public static function getInstagramProvider()
    {
        return new Instagram([
            'clientId' => $_ENV['INSTAGRAM_CLIENT_ID'],
            'clientSecret' => $_ENV['INSTAGRAM_CLIENT_SECRET'],
            'redirectUri' => $_ENV['INSTAGRAM_REDIRECT_URI'],
        ]);
    }
}
