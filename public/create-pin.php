<?php

use App\Database;
use App\Map;
use App\Pin;

// Add assets
App\AssetManager::getInstance()->addScript('leaflet');
App\AssetManager::getInstance()->addScript('ckEditor');
App\AssetManager::getInstance()->addStyle('leaflet');
App\AssetManager::getInstance()->addStyle('ckEditor');

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['wysiwyg'], $_POST['lat'], $_POST['lng'], $_POST['map'])) {
    $pdo = (new Database())->getConnection();
    $pin = new Pin($pdo);
    try {
        $pin->createPin($_POST['map'], $_SESSION['user_id'], $_POST['name'], $_POST['wysiwyg'], $_POST['lat'], $_POST['lng']);
        // Get the slug of this map
        $map = new Map($pdo);
        $mapData = $map->getMapById($_POST['map']);
        $slug = $mapData['slug'];
        // Redirect to the map
        header("Location: /m/$slug");
        exit;
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}

$view = [
    'bodyType' => 'half-screens',
    'errorMessage' => $errorMessage,
];

// View
include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/create-pin.php';
include __DIR__ . '/../views/footer.php';