<?php

use App\AssetManager;
use App\Database;
use App\Map;
use App\Pin;

// Add assets
AssetManager::getInstance()->addScript('leaflet');
AssetManager::getInstance()->addStyle('leaflet');

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
} catch (Exception $e) {
    exit($e->getMessage());
}

if (!$pinData) {
    http_response_code(404);
    exit;
}

// Get map data
try {
    $mapData = $map->getMapByPinSlug($pinData['slug']);
} catch (Exception $e) {
    http_response_code(500);
    exit;
}

$view = [
    'bodyType' => 'half-screens',
    'pageTitle' => $pinData['name'],
    'pinData' => $pinData ?? null,
    'mapData' => $mapData ?? null,
];

include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/view-pin.php';
include __DIR__ . '/../views/footer.php';