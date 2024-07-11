<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
?>
<html>
<head>
    <title>Mapamy</title>
    <link rel="stylesheet" href="/dist/style.css">
    <?php
    App\AssetManager::getInstance()->printStyles();
    App\AssetManager::getInstance()->printScripts();
    ?>
</head>
<body class="<?php echo $view['bodyType'] ?? 'full-screen'; ?>">