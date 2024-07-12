<?php

use App\AssetManager;
use App\Database;
use App\Map;
use App\Pin;

// Add assets
AssetManager::getInstance()->addScript('leaflet');
AssetManager::getInstance()->addStyle('leaflet');

if (!isset($_GET['slug'])) {
    http_response_code(404);
    exit;
}

$pdo = (new Database())->getConnection();
$map = new Map($pdo);
$pin = new Pin($pdo);

try {
    $mapData = $map->getMapBySlug($_GET['slug']);
    if (!$mapData) {
        http_response_code(404);
        exit;
    }
    $pins = $pin->getPinsByMapId($mapData['id']);
} catch (Exception $e) {
    exit($e->getMessage());
}

$view = [
    'bodyType' => 'half-screens',
    'mapData' => $mapData ?? null,
    'pins' => $pins ?? [],
    'isOwner' => isset($mapData) && $mapData['user_id'] === $_SESSION['user_id'],
];

// View
include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/view-map.php';
include __DIR__ . '/../views/footer.php';