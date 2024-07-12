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
    if ($view['isOwner']) {
        echo '<a href="/create-pin/' . $view['mapData']['id'] . '">Add Pin</a>';
    }
    ?>
    <div itemscope itemtype="https://schema.org/Map">
        <meta itemprop="name" content="<?php echo $view['mapData']['name']; ?>">
        <meta itemprop="description" content="<?php echo $view['mapData']['description']; ?>">
        <div itemprop="hasMap" itemscope itemtype="https://schema.org/Place">
            <ul>
                <?php foreach ($view['pins'] as $pin): ?>
                    <li data-lat="<?php echo $pin['latitude']; ?>" data-lng="<?php echo $pin['longitude']; ?>">
                        <div itemscope itemtype="https://schema.org/Place">
                            <h2 itemprop="name"><?php echo $pin['name']; ?></h2>
                            <p itemprop="description"><?php echo $pin['description']; ?></p>
                            <meta itemprop="latitude" content="<?php echo $pin['latitude']; ?>">
                            <meta itemprop="longitude" content="<?php echo $pin['longitude']; ?>">
                            <a href="/p/<?php echo $pin['slug']; ?>">View</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
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
                setMapView(lat, lng, 13);
            });
        });
    });
</script>