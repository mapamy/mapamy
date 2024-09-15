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
    $tmpName = $_FILES['upload']['tmp_name'];

    // Check if the file is less than 7 MB
    if ($_FILES['upload']['size'] > 7 * 1024 * 1024) {
        echo json_encode(['error' => 'Maximum allowed file size is 7 MB.']);
        exit;
    }

    // Check if there was an error during file upload
    if ($_FILES['upload']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['error' => 'File upload failed.']);
        exit;
    }

    // Validate the uploaded file
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($tmpName);

    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp', 'image/heic', 'image/heif'];

    if (!in_array($mimeType, $allowedMimeTypes)) {
        echo json_encode(['error' => 'Unsupported image type.']);
        exit;
    }

    try {
        // Load the image using Imagick
        $image = new Imagick($tmpName);

        // **Auto-orient the image according to EXIF data**
        $image->autoOrient();

        // Extract GPS coordinates from EXIF data if available
        $gpsCoordinates = false;
        $exifData = $image->getImageProperties("exif:*");

        if (!empty($exifData)) {
            $gpsCoordinates = extractGPSCoordinates($exifData);
        }

        // Resize image if necessary
        $maxDimension = 980;
        $width = $image->getImageWidth();
        $height = $image->getImageHeight();

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

            $image->resizeImage($newWidth, $newHeight, Imagick::FILTER_LANCZOS, 1);
        }

        // Set image format to WebP
        $image->setImageFormat('webp');
        $quality = 92;
        $image->setImageCompressionQuality($quality);

        // Save the image
        $fileName = uniqid('', true) . '.webp';
        $targetFilePath = $uploadsDir . '/' . $fileName;

        $image->writeImage($targetFilePath);

        $image->clear();
        $image->destroy();

        // Respond with the URL to the uploaded file and GPS coordinates
        $url = '/image/' . $_SESSION['user_id'] . '/' . $_GET['map_id'] . '/' . $fileName;
        echo json_encode(['url' => $url, 'gps' => $gpsCoordinates]);

    } catch (Exception $e) {
        echo json_encode(['error' => 'Failed to process the image.']);
        exit;
    }

} else {
    echo json_encode(['error' => 'No file uploaded.']);
}

// Function to extract GPS coordinates from EXIF data
function extractGPSCoordinates($exifData) {
    if (!isset($exifData['exif:GPSLatitude']) || !isset($exifData['exif:GPSLatitudeRef']) ||
        !isset($exifData['exif:GPSLongitude']) || !isset($exifData['exif:GPSLongitudeRef'])) {
        return false;
    }

    $latitude = getGPSCoordinate($exifData['exif:GPSLatitude'], $exifData['exif:GPSLatitudeRef']);
    $longitude = getGPSCoordinate($exifData['exif:GPSLongitude'], $exifData['exif:GPSLongitudeRef']);

    if ($latitude !== false && $longitude !== false) {
        return ['latitude' => $latitude, 'longitude' => $longitude];
    } else {
        return false;
    }
}

function getGPSCoordinate($coordinateString, $hemisphere) {
    $dms = explode(',', $coordinateString);
    if (count($dms) != 3) {
        return false;
    }

    $degrees = gps2Num($dms[0]);
    $minutes = gps2Num($dms[1]);
    $seconds = gps2Num($dms[2]);

    $decimal = $degrees + ($minutes / 60) + ($seconds / 3600);

    if ($hemisphere == 'S' || $hemisphere == 'W') {
        $decimal = -$decimal;
    }

    return $decimal;
}

function gps2Num($coordPart) {
    $parts = explode('/', $coordPart);
    if (count($parts) <= 0) {
        return 0;
    }

    if (count($parts) == 1) {
        return floatval($parts[0]);
    }

    return floatval($parts[0]) / floatval($parts[1]);
}
