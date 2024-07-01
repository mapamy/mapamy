<?php

use App\Database;
use App\Map;

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['description'])) {
    $pdo = (new Database())->getConnection();
    $map = new Map($pdo);
    try {
        $mapId = $map->createMap($_SESSION['user_id'], $_POST['name'], $_POST['description']);
        header('Location: /create-pin/' . $mapId);
        exit;
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}

$view = [
    'errorMessage' => $errorMessage,
];

// View
include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/create-map.php';
include __DIR__ . '/../views/footer.php';