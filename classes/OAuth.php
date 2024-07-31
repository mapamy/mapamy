<?php

namespace App;

use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Provider\Instagram;

class OAuth
{

    /**
     * Returns a Google provider.
     * @return Google
     */
    public static function getGoogleProvider(): Google
    {
        return new Google([
            'clientId' => $_ENV['GOOGLE_CLIENT_ID'],
            'clientSecret' => $_ENV['GOOGLE_CLIENT_SECRET'],
            'redirectUri' => $_ENV['GOOGLE_REDIRECT_URI'],
        ]);
    }

}
