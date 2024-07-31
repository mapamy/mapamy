<?php
use App\AssetManager;
if (!isset($view)) {
    exit('Data not passed to view');
}
?>
<html>
<head>
    <title><?php echo $view['pageTitle'] ?? __('Discover and share places'); ?> - Mapamy</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/dist/mapamy-icon.png">
    <link rel="stylesheet" href="/dist/style.css">
    <?php
    AssetManager::getInstance()->printStyles();
    AssetManager::getInstance()->printScripts();
    ?>
</head>
<body class="<?php echo $view['bodyType'] ?? 'full-screen'; ?>">