<?php

use App\AssetManager;
use App\Database;
use App\User;
use App\Map;
use App\Pin;

// Add assets
AssetManager::getInstance()->addScript('leaflet');
AssetManager::getInstance()->addStyle('leaflet');

$pdo = (new Database())->getConnection();
$User = new User($pdo);
$user = $User->getUserById($_SESSION['user_id']);

// Get maps by user ID
$Map = new Map($pdo);
$maps = $Map->getMapsByUserId($_SESSION['user_id']);

// Get pins by user ID
$Pin = new Pin($pdo);
$pins = $Pin->getPinsByUserId($_SESSION['user_id']);

$view = [
    'bodyType' => 'half-screens',
    'pageTitle' => __('Dashboard'),
    'baseUrl' => $_ENV['BASE_URL'],
    'email' => htmlspecialchars($user['email']),
    'maps' => $maps,
    'pins' => $pins,
];

// Load the home view
include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/dashboard.php';
include __DIR__ . '/../views/footer.php';
