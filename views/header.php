<?php
use App\AssetManager;

if (!isset($view)) {
    exit('Data not passed to view');
}
?>
<html>
<head>
    <title>Mapamy</title>
    <link rel="stylesheet" href="/dist/style.css">
    <?php
    AssetManager::getInstance()->printStyles();
    AssetManager::getInstance()->printScripts();
    ?>
</head>
<body class="<?php echo $view['bodyType'] ?? 'full-screen'; ?>">