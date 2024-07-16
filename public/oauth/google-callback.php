<?php

use App\OAuth;
use App\Database;
use App\User;

$provider = OAuth::getGoogleProvider();
$pdo = (new Database())->getConnection();
$User = new User($pdo);

if (!isset($_GET['code'])) {
    exit('Invalid response from Google');
}

try {
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    $googleUser = $provider->getResourceOwner($token);
    $user_data = $User->findOrCreateUser($googleUser->getEmail());

    $User->updateUserToken($user_data['id'], $token);

    $_SESSION['user_id'] = $user_data['id'];
    header('Location: /dashboard');
    exit;
} catch (Exception $e) {
    exit('Failed to authenticate with Google: ' . $e->getMessage());
}
