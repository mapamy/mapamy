<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
$mapData = $view['mapData'];
?>
<div class="main">
    <?php
    include __DIR__ . '/partials/site-header.php';
    ?>
    <h2><?= __('Create pin') ?></h2>
    <nav>
        <a href="/m/<?php echo $mapData['slug']; ?>"><?= __('Back to map') ?></a>
    </nav>
    <?php
    if (isset($view['errorMessage'])) {
        echo '<p>' . $view['errorMessage'] . '</p>';
    }
    ?>
    <form method="post" class="form">
        <div class="form-control">
            <label for="name"><?= __('Pin name') ?></label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-control">
            <label for="wysiwyg"><?= __('Description') ?></label>
            <textarea name="wysiwyg" id="wysiwyg" data-map-id="<?php echo $mapData['id']; ?>"></textarea>
        </div>
        <div class="form-control">
            <label for="lat"><?= __('Latitude') ?></label>
            <input type="text" id="lat" name="lat">
        </div>
        <div class="form-control">
            <label for="lng"><?= __('Longitude') ?></label>
            <input type="text" id="lng" name="lng">
        </div>
        <div class="form-control">
            <div class="g-recaptcha" data-sitekey="<?php echo $_ENV['RECAPTCHA_SITE_KEY']; ?>"></div>
        </div>
        <button type="submit" class="button"><?= __('Create pin') ?></button>
    </form>
</div>
<div id="leaflet-map" class="map"></div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let marker;
        const pins = <?php echo json_encode($view['pins']); ?>;
        const pinCoordinates = pins.map(pin => [pin.latitude, pin.longitude]);

        pins.forEach(pin => {
            window.leafletUtils.addMarker(pin.latitude, pin.longitude, `<b>${pin.name}</b><br>${pin.description}`);
        });

        window.leafletUtils.fitMapToMarkers(pinCoordinates);

        window.map.on('click', (e) => {
            document.getElementById('lat').value = e.latlng.lat;
            document.getElementById('lng').value = e.latlng.lng;

            if (marker) {
                window.map.removeLayer(marker);
            }

            marker = window.leafletUtils.addMarker(e.latlng.lat, e.latlng.lng);
        });
    });
</script>