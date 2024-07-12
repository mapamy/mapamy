<?php

// Get the image file path
$imgPath = __DIR__ . '/../uploads/' . $_GET['user_id'] . '/' . $_GET['map_id'] . '/' . $_GET['img_name'];

// Check if the image file exists
if (!file_exists($imgPath)) {
    http_response_code(404);
    exit;
}

// Serve the webp image
header('Content-Type: image/webp');
readfile($imgPath);
