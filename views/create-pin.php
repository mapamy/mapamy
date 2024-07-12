<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
$mapData = $view['mapData'];
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
        <button type="submit" class="button">Create Pin</button>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let marker;

            window.map.on('click', (e) => {
                document.getElementById('lat').value = e.latlng.lat;
                document.getElementById('lng').value = e.latlng.lng;

                if (marker) {
                    window.map.removeLayer(marker);
                }

                marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(window.map);
            })
        });
    </script>
</div>