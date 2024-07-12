<?php

use App\Database;
use App\Map;
use App\Pin;

// Add assets
App\AssetManager::getInstance()->addScript('ckEditor');
App\AssetManager::getInstance()->addStyle('ckEditor');

$errorMessage = '';
$pinData = [];
$mapData = [];

$pdo = (new Database())->getConnection();
$pin = new Pin($pdo);
$map = new Map($pdo);

// Make sure this pin exists
try {
    $pinData = $pin->getPinById($_GET['id']);
    if (!$pinData) {
        throw new Exception("Pin not found");
    }
    $mapData = $map->getMapById($pinData['map_id']);
} catch (Exception $e) {
    http_response_code(404);
    echo "Pin or Map not found";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['slug'], $_POST['description'], $_POST['wysiwyg'], $_POST['latitude'], $_POST['longitude'])) {
    try {
        $updateSuccess = $pin->updatePin($_GET['id'], $_POST['name'], $_POST['slug'], $_POST['description'], $_POST['wysiwyg'], $_POST['latitude'], $_POST['longitude']);
        if (!$updateSuccess) {
            throw new Exception("Failed to update pin");
        }
        header('Location: /m/' . $mapData['slug']);
        exit;
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}

$view = [
    'errorMessage' => $errorMessage,
    'pinData' => $pinData,
    'mapData' => $mapData,
];

// View
include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/edit-pin.php';
include __DIR__ . '/../views/footer.php';