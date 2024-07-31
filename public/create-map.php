<?php

use App\AssetManager;
use App\Database;
use App\Map;
use App\Utils;

// Add assets
AssetManager::getInstance()->addScript('ckEditor');
AssetManager::getInstance()->addStyle('ckEditor');
AssetManager::getInstance()->addScript('https://www.google.com/recaptcha/api.js');

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['description']) && isset($_POST['g-recaptcha-response'])) {
    if (!Utils::isRecaptchaTokenVerificationSuccessful($_POST['g-recaptcha-response'])) {
        $errorMessage = __('Recaptcha verification failed');
    } else {
        $pdo = (new Database())->getConnection();
        $map = new Map($pdo);
        try {
            $mapId = $map->createMap($_SESSION['user_id'], $_POST['name'], $_POST['description'], $_POST['privacy']);
            header('Location: /edit-map/' . $mapId);
            exit;
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
        }
    }
}

$view = [
    'errorMessage' => $errorMessage,
];

// View
include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/create-map.php';
include __DIR__ . '/../views/footer.php';