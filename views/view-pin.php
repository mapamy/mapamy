<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
?>
<div class="main">
    <?php
    include __DIR__ . '/partials/site-header.php';
    ?>
    <h2><?= __('Pin') ?>: <?php echo $view['pinData']['name']; ?></h2>
    <nav>
        <a href="/"><?= __('Back home') ?></a>
        <a href="/edit-pin/<?php echo $view['pinData']['id']; ?>"><?= __('Edit pin') ?></a>
        <a href="/m/<?php echo $view['mapData']['slug']; ?>"><?= __('Back to map') ?></a>
    </nav>
    <h1><?php echo $view['pinData']['name']; ?></h1>
    <div itemscope itemtype="https://schema.org/Map">
        <meta itemprop="name" content="<?php echo $view['pinData']['name']; ?>">
        <meta itemprop="description" content="<?php echo $view['pinData']['description']; ?>">
        <div itemprop="hasMap" itemscope itemtype="https://schema.org/Place">
            <div data-lat="<?php echo $view['pinData']['latitude']; ?>"
                 data-lng="<?php echo $view['pinData']['longitude']; ?>">
                <div itemscope itemtype="https://schema.org/Place">
                    <div itemprop="description"><?php echo $view['pinData']['wysiwyg']; ?></div>
                    <meta itemprop="latitude" content="<?php echo $view['pinData']['latitude']; ?>">
                    <meta itemprop="longitude" content="<?php echo $view['pinData']['longitude']; ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<div id="leaflet-map" class="map"></div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lat = <?php echo json_encode($view['pinData']['latitude']); ?>;
        const lng = <?php echo json_encode($view['pinData']['longitude']); ?>;
        const popupContent = `<b><?php echo $view['pinData']['name']; ?></b><br><?php echo strip_tags($view['pinData']['wysiwyg']); ?>`;

        window.leafletUtils.setMapView(lat, lng, 13);
        window.leafletUtils.addMarker(lat, lng, popupContent);
    });
</script>