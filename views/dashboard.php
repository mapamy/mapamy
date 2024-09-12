<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
?>
<div class="main">
    <?php
    include __DIR__ . '/partials/site-header.php';
    ?>
    <h2><?= __('Dashboard') ?></h2>
    <nav>
        <a href='<?php echo $view['baseUrl']; ?>/create-map'><?= __('Create map') ?></a>
        <a href='<?php echo $view['baseUrl']; ?>/logout'><?= __('Logout') ?></a>
    </nav>
    <h2><?= __('My maps') ?></h2>
    <?php if (empty($view['maps'])) { ?>
        <p><?= __('You have no maps yet') ?></p>
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