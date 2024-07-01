<?php

use App\Database;
use App\User;

if (!isset($_SESSION['user_id'])) {
    header('Location: /index');
    exit;
}

$pdo = (new Database())->getConnection();
$User = new User($pdo);
$user = $User->getUserById($_SESSION['user_id']);

$view = [
    'baseUrl' => $_ENV['BASE_URL'],
    'email' => htmlspecialchars($user['email']),
];

// Load the home view
include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/dashboard.php';
include __DIR__ . '/../views/footer.php';
