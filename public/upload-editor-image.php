<?php
// Cancel operation if user is not logged in or map id is not provided
if (!isset($_SESSION['user_id']) || !isset($_GET['map_id'])) {
    exit;
}

// Ensure the uploads directory exists
$uploadsDir = __DIR__ . '/../uploads/' . $_SESSION['user_id'] . '/' . $_GET['map_id'];
if (!file_exists($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
}

// Handle file upload
if (isset($_FILES['upload'])) {
    $fileType = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);

    // Validate file type (for example, only images)
    $allowTypes = ['jpg', 'jpeg', 'png', 'gif', 'avif', 'apng', 'svg', 'webp'];
    if (in_array(strtolower($fileType), $allowTypes)) {
        try {
            $image = new Imagick($_FILES['upload']['tmp_name']);

            // Resize image if necessary
            $maxDimension = 980;
            $image->resizeImage($maxDimension, $maxDimension, Imagick::FILTER_LANCZOS, 1, true);

            // Convert to WebP
            $image->setImageFormat('webp');

            // Generate a unique file name
            $fileName = uniqid('', true) . '.webp';
            $targetFilePath = $uploadsDir . '/' . $fileName;

            // Write the image to the target file path
            $image->writeImage($targetFilePath);
            $image->clear();
            $image->destroy();

            // Respond with the URL to the uploaded file
            $url = '/image/' . $_SESSION['user_id'] . '/' . $_GET['map_id'] . '/' . $fileName;
            echo json_encode(['url' => $url]);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Error processing image: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid file type.']);
    }
} else {
    echo json_encode(['error' => 'No file uploaded.']);
}