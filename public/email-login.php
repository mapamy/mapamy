<?php

use App\Database;
use App\User;
use App\Email;
use App\AssetManager;
use App\Utils;

if (isset($_SESSION['user_id'])) {
    header('Location: /dashboard');
    exit;
}

// Add assets
AssetManager::getInstance()->addScript('https://www.google.com/recaptcha/api.js');

$pdo = (new Database())->getConnection();
$User = new User($pdo);
$errorMessage = '';
$loginLinkSent = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['g-recaptcha-response'])) {
    // Check if the recaptcha token is valid
    if (!Utils::isRecaptchaTokenVerificationSuccessful($_POST['g-recaptcha-response'])) {
        $errorMessage = __('Recaptcha verification failed');
    }else {
        // Find or create the user and send login link
        $email = $_POST['email'];
        $user = $User->findOrCreateUser($email);
        $token = $User->updateUserToken($user['id']);

        // Send the email with the login link
        $emailClass = new Email();
        $subject = __('Login Link');
        $body = __('Use the following link to log in:') . $_ENV['BASE_URL'] . '/email-login?email=' . urlencode($email) . '&token=' . urlencode($token);
        $emailClass->sendEmail($email, $subject, $body);
        $loginLinkSent = true;
    }
} elseif (isset($_GET['email']) && isset($_GET['token'])) {
    $email = urldecode($_GET['email']);
    $token = urldecode($_GET['token']);

    $user = $User->getUserByEmail($email);

    if ($user && hash_equals($user['token'], $token)) {
        // Log in the user
        $_SESSION['user_id'] = $user['id'];
        header('Location: /dashboard');
        exit;
    } else {
        $errorMessage = __('Invalid login link');
    }
}

// View
$view = [
    'loginLinkSent' => $loginLinkSent,
    'errorMessage' => $errorMessage,
];

include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/email-login.php';
include __DIR__ . '/../views/footer.php';