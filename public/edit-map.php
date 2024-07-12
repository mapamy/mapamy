<?php

use App\Database;
use App\Map;

// Add assets
App\AssetManager::getInstance()->addScript('ckEditor');
App\AssetManager::getInstance()->addStyle('ckEditor');

$errorMessage = '';
$mapData = [];

$pdo = (new Database())->getConnection();
$map = new Map($pdo);

// Make sure this map exists
try {
    $mapData = $map->getMapById($_GET['id']);
} catch (Exception $e) {
    http_response_code(404);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['slug'], $_POST['description'], $_POST['wysiwyg'], $_POST['privacy'])) {
    try {
        $map->updateMap($_GET['id'], $_POST['name'], $_POST['slug'], $_POST['description'], $_POST['wysiwyg'], $_POST['privacy']);
        header('Location: /m/' . $_POST['slug']);
        exit;
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}

$view = [
    'errorMessage' => $errorMessage,
    'mapData' => $mapData,
];

// View
include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/edit-map.php';
include __DIR__ . '/../views/footer.php';