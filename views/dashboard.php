<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
?>
<div class="main">
    <h1><?php echo $view['email']; ?></h1>
    <ul>
        <li><a href='<?php echo $view['baseUrl']; ?>/create-map'>Create a map</a></li>
    </ul>

    <h2>Maps</h2>
    <?php if (empty($view['maps'])) { ?>
        <p>You have no maps yet.</p>
    <?php } else { ?>
        <ul>
            <?php foreach ($view['maps'] as $map) { ?>
                <li>
                    <a href='<?php echo $view['baseUrl']; ?>/m/<?php echo $map['slug']; ?>'><?php echo $map['name']; ?></a>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>
</div>
<div id="leaflet-map" class="map"></div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pins = <?php echo json_encode($view['pins']); ?>;
        const pinCoordinates = pins.map(pin => [pin.latitude, pin.longitude]);

        pins.forEach(pin => {
            window.leafletUtils.addMarker(pin.latitude, pin.longitude, `<b>${pin.name}</b><br>${pin.description}`);
        });

        window.leafletUtils.fitMapToMarkers(pinCoordinates);

        const pinListItems = document.querySelectorAll('li[data-lat][data-lng]');
        pinListItems.forEach(item => {
            item.addEventListener('click', () => {
                const lat = item.getAttribute('data-lat');
                const lng = item.getAttribute('data-lng');
                window.leafletUtils.setMapView(lat, lng, 13);
            });
        });
    });
</script>