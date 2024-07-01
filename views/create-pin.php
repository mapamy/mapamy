<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
?>
<?php
if (isset($view['errorMessage'])) {
    echo '<p>' . $view['errorMessage'] . '</p>';
}
?>
<div id="map-id" style="height: 180px;"></div>
<form method="post">
    <label for="name">Pin Name</label>
    <input type="text" id="name" name="name" required>
    <label for="description">Description</label>
    <textarea id="description" name="description" required></textarea>
    <input type="text" id="lat" name="lat">
    <input type="text" id="lng" name="lng">
    <input type="text" id="map" name="map" value="<?php echo $_GET['map']; ?>">
    <button type="submit">Create Pin</button>
</form>
<script>
    const map = L.map('map-id').setView([51.505, -0.09], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    let marker;

    map.on('click', (e) => {
        document.getElementById('lat').value = e.latlng.lat;
        document.getElementById('lng').value = e.latlng.lng;

        if (marker) {
            map.removeLayer(marker);
        }

        marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
    });
</script>