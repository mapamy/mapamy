<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
?>
<div class="main">
    <?php
    include __DIR__ . '/partials/site-header.php';
    ?>
    <h2><?= __('Map') ?>: <?php echo $view['mapData']['name']; ?></h2>
    <nav>
        <a href="/"><?= __('Back home') ?></a>
        <?php
        if ($view['isOwner']) {
            echo '<a href="/edit-map/' . $view['mapData']['id'] . '">' . __('Edit map') . '</a>';
            echo '<a href="/create-pin/' . $view['mapData']['id'] . '">' . __('Add pin') . '</a>';
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
                    <li class="pin-grid__pin" data-lat="<?php echo $pin['latitude']; ?>"
                        data-lng="<?php echo $pin['longitude']; ?>">
                        <div itemscope itemtype="https://schema.org/Place">
                            <span itemprop="name" class="pin-grid__pin-title"><?php echo $pin['name']; ?></span>
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
        const markers = [];
        const markerCoordinates = []; // Array to store marker positions

        pins.forEach(pin => {
            const description = pin.description ? `<p>${pin.description}</p>` : '';

            // Disable Leaflet's default auto-pan
            const popupOptions = {
                autoPan: false,
            };

            const marker = window.leafletUtils.addMarker(
                pin.latitude,
                pin.longitude,
                `
                <b>${pin.name}</b>
                ${description}
                <a class="button" href="/p/${pin.slug}"><?= __('View pin') ?></a>
                `,
                popupOptions
            );

            // Adjust the map center when the popup opens
            marker.on('popupopen', () => {
                const popupElement = marker.getPopup().getElement();
                const popupHeight = popupElement.offsetHeight;
                const mapSize = window.map.getSize();

                // Marker position in pixel coordinates
                const markerPoint = window.map.latLngToContainerPoint(marker.getLatLng());

                // Desired center coordinates in pixel space
                // Horizontally center on the marker
                const desiredCenterX = markerPoint.x;
                // Vertically center the popup and marker
                const desiredCenterY = markerPoint.y - (popupHeight / 2);

                // Convert desired center pixel coordinates back to LatLng
                const desiredCenterLatLng = window.map.containerPointToLatLng([desiredCenterX, desiredCenterY]);

                // Set the map view to the desired center without changing the zoom level
                window.map.setView(desiredCenterLatLng, window.map.getZoom(), { animate: true });
            });

            markers.push(marker);
            markerCoordinates.push([pin.latitude, pin.longitude]); // Collect marker positions
        });

        // After adding all markers, fit the map to the bounds of all markers
        if (markerCoordinates.length > 0) {
            const bounds = L.latLngBounds(markerCoordinates);
            window.map.fitBounds(bounds, { padding: [20, 20] }); // Adjust padding as needed
        }

        // Add event listeners to the pin grid items
        const pinListItems = document.querySelectorAll('li.pin-grid__pin');
        pinListItems.forEach((item, index) => {
            item.addEventListener('click', () => {
                // Close all popups
                markers.forEach(marker => marker.closePopup());
                const marker = markers[index];

                // Check if the marker is within the current map bounds
                if (!window.map.getBounds().contains(marker.getLatLng())) {
                    // Pan the map to the marker's location
                    window.map.panTo(marker.getLatLng(), { animate: true });
                    // Wait for the map to finish panning before opening the popup
                    window.map.once('moveend', () => {
                        marker.openPopup();
                    });
                } else {
                    // Open the popup immediately
                    marker.openPopup();
                }
            });
        });
    });
</script>