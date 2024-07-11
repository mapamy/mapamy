<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
?>
<div id="map-id" class="map"></div>
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
        <textarea name="wysiwyg" id="wysiwyg"></textarea>
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
        <label for="map">Map ID</label>
        <input type="text" id="map" name="map" value="<?php echo $_GET['map']; ?>">
    </div>
    <button type="submit" class="button">Create Pin</button>
</form>
<script>
    const map = L.map('map-id').setView([51.505, -0.09], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    let marker;

    var customIcon = L.icon({
        iconUrl: '/dist/leaflet-marker.png',
        iconSize: [38, 95], // size of the icon
        iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
        popupAnchor: [-3, -76] // point from which the popup should open relative to the iconAnchor
    })

    map.on('click', (e) => {
        document.getElementById('lat').value = e.latlng.lat;
        document.getElementById('lng').value = e.latlng.lng;

        if (marker) {
            map.removeLayer(marker);
        }

        marker = L.marker([e.latlng.lat, e.latlng.lng], { icon: customIcon }).addTo(map);
    });
</script>
</div>