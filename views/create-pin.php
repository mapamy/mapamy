<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
$mapData = $view['mapData'];
?>
<div class="main">
    <h1>Mapamy</h1>
    <h2>Create pin</h2>
    <nav>
        <a href="/">Home</a>
        <a href="/m/<?php echo $mapData['slug']; ?>">Back to Map</a>
    </nav>
    <?php
    if (isset($view['errorMessage'])) {
        echo '<p>' . $view['errorMessage'] . '</p>';
    }
    ?>
    <form method="post" class="form">
        <div class="form-control">
            <label for="name">Pin Name</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-control">
            <label for="wysiwyg">Content</label>
            <textarea name="wysiwyg" id="wysiwyg" data-map-id="<?php echo $mapData['id']; ?>"></textarea>
        </div>
        <div class="form-control">
            <label for="lat">Latitude</label>
            <input type="text" id="lat" name="lat">
        </div>
        <div class="form-control">
            <label for="lng">Longitude</label>
            <input type="text" id="lng" name="lng">
        </div>
        <div class="form-control">
            <div class="g-recaptcha" data-sitekey="<?php echo $_ENV['RECAPTCHA_SITE_KEY']; ?>"></div>
        </div>
        <button type="submit" class="button">Create Pin</button>
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