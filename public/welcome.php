<?php

// Redirect to dashbaord if logged in
if (isset($_SESSION['user_id'])) {
    header('Location: /dashboard');
    exit;
}

$view = [
    'baseUrl' => $_ENV['BASE_URL'],
];

// Load the home view
include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/home.php';
include __DIR__ . '/../views/footer.php';