<?php

use App\Database;
use App\Map;
use App\Pin;

// Add assets
App\AssetManager::getInstance()->addScript('leaflet');
App\AssetManager::getInstance()->addScript('ckEditor');
App\AssetManager::getInstance()->addStyle('leaflet');
App\AssetManager::getInstance()->addStyle('ckEditor');

$pdo = (new Database())->getConnection();
$map = new Map($pdo);

// Make sure this map exists
try {
    $mapData = $map->getMapById($_GET['id']);
} catch (Exception $e) {
    http_response_code(404);
    exit;
}

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['wysiwyg'], $_POST['lat'], $_POST['lng'])) {
    $pin = new Pin($pdo);
    try {
        $pin->createPin($_GET['id'], $_SESSION['user_id'], $_POST['name'], $_POST['wysiwyg'], $_POST['lat'], $_POST['lng']);
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
    'mapData' => $mapData,
    'errorMessage' => $errorMessage,
];

// View
include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/create-pin.php';
include __DIR__ . '/../views/footer.php';