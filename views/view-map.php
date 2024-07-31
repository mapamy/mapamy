<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
?>
<div class="main">
    <?php
    include __DIR__ . '/partials/site-header.php';
    ?>
    <h2><?= __('Map') ?> <?php echo $view['mapData']['name']; ?></h2>
    <nav>
        <a href="/"><?= __('Back home') ?></a>
    <?php
    if ($view['isOwner']) {
        echo '<a href="/edit-map/' . $view['mapData']['id'] . '">' . __('Edit map') . '</a>';
        echo '<a href="/create-pin/' . $view['mapData']['id'] . '">' . __('Add pin')  . '</a>';
    }
    ?>
    </nav>
    <div itemscope itemtype="https://schema.org/Map">
        <meta itemprop="name" content="<?php echo $view['mapData']['name']; ?>">
        <meta itemprop="description" content="<?php echo $view['mapData']['description']; ?>">
        <div itemprop="hasMap" itemscope itemtype="https://schema.org/Place">
            <h3><?= __('Pins') ?></h3>
            <ul class="pin-grid">
                <?php foreach ($view['pins'] as $pin): ?>
                    <li class="pin-grid__pin" data-lat="<?php echo $pin['latitude']; ?>" data-lng="<?php echo $pin['longitude']; ?>">
                        <div itemscope itemtype="https://schema.org/Place">
                            <span itemprop="name" class="pin-grid__pin-title"><?php echo $pin['name']; ?></span>
                            <span itemprop="description"><?php echo $pin['description']; ?></span>
                            <meta itemprop="latitude" content="<?php echo $pin['latitude']; ?>">
                            <meta itemprop="longitude" content="<?php echo $pin['longitude']; ?>">
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <section itemprop="description"><?php echo $view['mapData']['wysiwyg']; ?></section>
        </div>
    </div>
</div>
<div id="leaflet-map" class="map"></div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pins = <?php echo json_encode($view['pins']); ?>;
        const pinCoordinates = pins.map(pin => [pin.latitude, pin.longitude]);

        pins.forEach(pin => {
            window.leafletUtils.addMarker(pin.latitude, pin.longitude, `<b>${pin.name}</b><br><?= __('Link') ?>: <a href="/p/${pin.slug}"><?= __('View pin') ?></a>`);
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