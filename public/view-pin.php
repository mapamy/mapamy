<?php

use App\Database;
use App\Map;
use App\Pin;

// Add assets
App\AssetManager::getInstance()->addScript('leaflet');
App\AssetManager::getInstance()->addStyle('leaflet');

$errorMessage = '';

if (!isset($_GET['slug'])) {
    http_response_code(404);
    exit;
}

$pdo = (new Database())->getConnection();
$pin = new Pin($pdo);
$map = new Map($pdo);

// Get pin data
try {
    $pinData = $pin->getPinBySlug($_GET['slug']);
    if (!$pinData) {
        http_response_code(404);
        exit('Pin not found');
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
}

// Get map data
$mapData = $map->getMapByPinSlug($_GET['slug']);

$view = [
    'bodyType' => 'half-screens',
    'errorMessage' => $errorMessage,
    'pinData' => $pinData ?? null,
    'mapData' => $mapData ?? null,
];

include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/view-pin.php';
include __DIR__ . '/../views/footer.php';