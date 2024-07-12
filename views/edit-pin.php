<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
$mapData = $view['mapData'];
$pinData = $view['pinData'];
?>
<div id="leaflet-map" class="map"></div>
<div class="main">
    <?php
    if (isset($view['errorMessage'])) {
        echo '<p>' . $view['errorMessage'] . '</p>';
    }
    ?>
    <form method="post" class="form">
        <div class="form-control">
            <label for="name">Pin Name</label>
            <input type="text" id="name" name="name" required
                   value="<?php echo htmlspecialchars($pinData['name'] ?? ''); ?>">
        </div>
        <div class="form-control">
            <label for="slug">Slug</label>
            <input type="text" id="slug" name="slug" required
                   value="<?php echo htmlspecialchars($pinData['slug'] ?? ''); ?>">
        </div>
        <div class="form-control">
            <label for="description">Description</label>
            <textarea name="description"
                      id="description"><?php echo htmlspecialchars($pinData['description'] ?? ''); ?></textarea>
        </div>
        <div class="form-control">
            <label for="wysiwyg">Content</label>
            <textarea name="wysiwyg" id="wysiwyg"
                      data-map-id="<?php echo $mapData['id']; ?>"><?php echo $pinData['content'] ?? ''; ?></textarea>
        </div>
        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" id="latitude" name="latitude" required
                   value="<?php echo htmlspecialchars($pinData['latitude'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" id="longitude" name="longitude" required
                   value="<?php echo htmlspecialchars($pinData['longitude'] ?? ''); ?>">
        </div>
        <button type="submit" class="button">Update Pin</button>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let marker = L.marker([parseFloat(<?php echo $pinData['latitude']; ?>), parseFloat(<?php echo $pinData['longitude']; ?>)]).addTo(window.map);

        window.map.on('click', function (e) {
            // Remove the existing marker
            if (marker) {
                window.map.removeLayer(marker);
            }

            // Update the latitude and longitude input fields
            document.getElementById('latitude').value = e.latlng.lat.toFixed(6);
            document.getElementById('longitude').value = e.latlng.lng.toFixed(6);

            // Add a new marker at the clicked location
            marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(window.map);
        });
    });
</script>