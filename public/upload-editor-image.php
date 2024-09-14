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
    // Validate the uploaded file
    $imageInfo = getimagesize($_FILES['upload']['tmp_name']);

    if ($imageInfo === false) {
        echo json_encode(['error' => 'Invalid image file.']);
        exit;
    }

    $imageType = $imageInfo[2]; // An integer representing the image type

    $allowedImageTypes = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP, IMAGETYPE_BMP];

    if (!in_array($imageType, $allowedImageTypes)) {
        echo json_encode(['error' => 'Unsupported image type.']);
        exit;
    }

    // Load the image
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($_FILES['upload']['tmp_name']);
            break;
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($_FILES['upload']['tmp_name']);
            break;
        case IMAGETYPE_GIF:
            $image = imagecreatefromgif($_FILES['upload']['tmp_name']);
            break;
        case IMAGETYPE_WEBP:
            $image = imagecreatefromwebp($_FILES['upload']['tmp_name']);
            break;
        case IMAGETYPE_BMP:
            $image = imagecreatefrombmp($_FILES['upload']['tmp_name']);
            break;
        default:
            echo json_encode(['error' => 'Unsupported image type.']);
            exit;
    }

    if (!$image) {
        echo json_encode(['error' => 'Failed to load image.']);
        exit;
    }

    // Resize image if necessary
    $width = imagesx($image);
    $height = imagesy($image);

    $maxDimension = 980;

    if ($width > $maxDimension || $height > $maxDimension) {
        if ($width > $height) {
            $newWidth = $maxDimension;
            $newHeight = $maxDimension * ($height / $width);
        } else {
            $newHeight = $maxDimension;
            $newWidth = $maxDimension * ($width / $height);
        }

        $newWidth = round($newWidth);
        $newHeight = round($newHeight);

        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        // Handle transparency for PNG, GIF, and WebP
        if ($imageType == IMAGETYPE_GIF || $imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_WEBP) {
            imagecolortransparent($newImage, imagecolorallocatealpha($newImage, 0, 0, 0, 127));
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
        }

        // Resample the image
        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Replace the original image with the resized one
        imagedestroy($image);
        $image = $newImage;
    }

    // Convert to WebP and save
    $fileName = uniqid('', true) . '.webp';
    $targetFilePath = $uploadsDir . '/' . $fileName;

    $quality = 80; // Adjust quality as needed
    $result = imagewebp($image, $targetFilePath, $quality);

    imagedestroy($image);

    if (!$result) {
        echo json_encode(['error' => 'Failed to save the image.']);
        exit;
    }

    // Respond with the URL to the uploaded file
    $url = '/image/' . $_SESSION['user_id'] . '/' . $_GET['map_id'] . '/' . $fileName;
    echo json_encode(['url' => $url]);

} else {
    echo json_encode(['error' => 'No file uploaded.']);
}
