<?php

use App\OAuth;

$provider = OAuth::getGoogleProvider();
$authUrl = $provider->getAuthorizationUrl();
$_SESSION['oauth2state'] = $provider->getState();

header('Location: ' . $authUrl);
exit;
