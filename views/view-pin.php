<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
?>
<div class="main">
    <?php
    if (isset($view['errorMessage'])) {
        echo '<p>' . $view['errorMessage'] . '</p>';
    }
    ?>
    <div itemscope itemtype="https://schema.org/Map">
    <meta itemprop="name" content="<?php echo $view['pinData']['name']; ?>">
    <meta itemprop="description" content="<?php echo $view['pinData']['description']; ?>">
    <div itemprop="hasMap" itemscope itemtype="https://schema.org/Place">
        <div data-lat="<?php echo $view['pinData']['latitude']; ?>" data-lng="<?php echo $view['pinData']['longitude']; ?>">
            <div itemscope itemtype="https://schema.org/Place">
                <h2 itemprop="name"><?php echo $view['pinData']['name']; ?></h2>
                <a href="/m/<?php echo $view['mapData']['slug']; ?>">Back to Map</a>
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
    document.addEventListener('DOMContentLoaded', function() {
        const lat = <?php echo json_encode($view['pinData']['latitude']); ?>;
        const lng = <?php echo json_encode($view['pinData']['longitude']); ?>;
        const map = L.map('leaflet-map').setView([lat, lng], 13);

        L.marker([lat, lng]).addTo(window.map)
            .bindPopup(`<b><?php echo $view['pinData']['name']; ?></b><br><?php echo strip_tags($view['pinData']['wysiwyg']); ?>`);
    });
</script>