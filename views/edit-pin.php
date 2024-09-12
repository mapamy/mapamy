<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
$mapData = $view['mapData'];
$pinData = $view['pinData'];
?>
<div class="main">
    <?php
    include __DIR__ . '/partials/site-header.php';
    ?>
    <h2><?= __('Edit pin') ?></h2>
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
            <input type="text" id="name" name="name" required
                   value="<?php echo htmlspecialchars($pinData['name'] ?? ''); ?>">
        </div>
        <div class="form-control">
            <label for="slug">Slug</label>
            <input type="text" id="slug" name="slug" required
                   value="<?php echo htmlspecialchars($pinData['slug'] ?? ''); ?>">
        </div>
        <div class="form-control">
            <label for="description"><?= __('Description') ?></label>
            <textarea name="description"
                      id="description"><?php echo htmlspecialchars($pinData['description'] ?? ''); ?></textarea>
        </div>
        <div class="form-control">
            <label for="wysiwyg"><?= __('Content') ?></label>
            <textarea name="wysiwyg" id="wysiwyg"
                      data-map-id="<?php echo $mapData['id']; ?>"><?php echo $pinData['wysiwyg'] ?? ''; ?></textarea>
        </div>
        <div class="form-group">
            <label for="latitude"><?= __('Latitude') ?>'</label>
            <input type="text" id="latitude" name="latitude" required
                   value="<?php echo htmlspecialchars($pinData['latitude'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="longitude"><?= __('Longitude') ?></label>
            <input type="text" id="longitude" name="longitude" required
                   value="<?php echo htmlspecialchars($pinData['longitude'] ?? ''); ?>">
        </div>
        <button type="submit" class="button button--green"><?= __('Update pin') ?></button>
    </form>
</div>
<div id="leaflet-map" class="map"></div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lat = parseFloat(<?php echo $pinData['latitude']; ?>);
        const lng = parseFloat(<?php echo $pinData['longitude']; ?>);

        // Initialize marker at the pin's location and center the view on it
        let marker = window.leafletUtils.addMarker(lat, lng);
        window.leafletUtils.setMapView(lat, lng, 13);

        window.map.on('click', function (e) {
            // Remove the existing marker
            if (marker) {
                window.map.removeLayer(marker);
            }

            // Update the latitude and longitude input fields
            document.getElementById('latitude').value = e.latlng.lat.toFixed(6);
            document.getElementById('longitude').value = e.latlng.lng.toFixed(6);

            // Add a new marker at the clicked location using window.leafletUtils
            // and center the view on the new marker
            marker = window.leafletUtils.addMarker(e.latlng.lat, e.latlng.lng);
            window.leafletUtils.setMapView(e.latlng.lat, e.latlng.lng, 13);
        });
    });
</script>