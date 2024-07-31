<?php

use App\Database;
use App\Map;

// Redirect to dashboard if logged in
if (isset($_SESSION['user_id'])) {
    header('Location: /dashboard');
    exit;
}

// Get the database connection
$pdo = (new Database())->getConnection();

// Create a new map instance
$map = new Map($pdo);

// Get 10 random maps
$maps = $map->getRandomMaps(10);

$view = [
    'baseUrl' => $_ENV['BASE_URL'],
    'maps' => $maps,
];

// Load the home view
include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/home.php';
include __DIR__ . '/../views/footer.php';