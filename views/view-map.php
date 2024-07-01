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
<?php
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
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<script>
    const map = L.map('map-id').setView([51.505, -0.09], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    const pins = <?php echo json_encode($view['pins']); ?>;
    pins.forEach(pin => {
        L.marker([pin.latitude, pin.longitude]).addTo(map)
            .bindPopup(`<b>${pin.name}</b><br>${pin.description}`);
    });

    const pinListItems = document.querySelectorAll('li[data-lat][data-lng]');
    pinListItems.forEach(item => {
        item.addEventListener('click', () => {
            const lat = item.getAttribute('data-lat');
            const lng = item.getAttribute('data-lng');
            map.setView([lat, lng], 13);
        });
    });
</script>