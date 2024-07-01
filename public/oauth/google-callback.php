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
    $user = $User->findOrCreateUser(
        $googleUser->getEmail(),
        'google',
        $googleUser->getId(),
    );

    $User->updateUserToken($user['id'], $token);

    $_SESSION['user_id'] = $user['id'];
    header('Location: /dashboard.php');
    exit;
} catch (Exception $e) {
    exit('Failed to authenticate with Google: ' . $e->getMessage());
}
