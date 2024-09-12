<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
?>
<main class="main home">
    <?php
    include __DIR__ . '/partials/site-header.php';
    ?>
    <h2><?= __('What?') ?></h2>
    <p>
        <?php
        echo match ($_SESSION['language']) {
            'es' => '¡Crea y comparte mapas personalizados de tus lugares favoritos! Desde gemas ocultas hasta lugares locales, nuestra plataforma te permite marcar sitios con descripciones y fotos, creando viajes únicos y recuerdos. Ya sean guías de viaje o lugares secretos, ¡empieza a mapear y compartir tu mundo hoy!',
            'fr' => 'Créez et partagez des cartes personnalisées de vos endroits préférés ! Des trésors cachés aux favoris locaux, notre plateforme vous permet d\'épingler des lieux avec des descriptions et des photos, créant des voyages uniques et des souvenirs. Qu\'il s\'agisse de guides de voyage ou de lieux secrets, commencez à cartographier et partager votre monde dès aujourd\'hui !',
            'de' => 'Erstellen und teilen Sie personalisierte Karten Ihrer Lieblingsorte! Von versteckten Schätzen bis hin zu lokalen Favoriten ermöglicht unsere Plattform das Markieren von Orten mit Beschreibungen und Fotos, um einzigartige Reisen und Erinnerungen zu schaffen. Ob Reiseführer oder geheime Treffpunkte, beginnen Sie noch heute, Ihre Welt zu kartieren und zu teilen!',
            'it' => 'Crea e condividi mappe personalizzate dei tuoi luoghi preferiti! Dai tesori nascosti ai luoghi preferiti, la nostra piattaforma ti consente di aggiungere punti con descrizioni e foto, creando viaggi unici e ricordi. Che si tratti di guide di viaggio o luoghi segreti, inizia a mappare e condividere il tuo mondo oggi stesso!',
            default => 'Create and share personalized maps of your favorite places! From hidden gems to local favorites, our platform lets you pin spots with descriptions and photos, crafting unique journeys and memories. Whether it\'s travel guides or secret hangouts, start mapping and sharing your world today!',
        };
        ?>
    </p>
    <h2><?= __('Access') ?></h2>
    <ul>
        <li><a href='<?php echo $view['baseUrl']; ?>/google-login'><?= __('With Google') ?></a>
        </li>
        <li><a href='<?php echo $view['baseUrl']; ?>/email-login'><?= __('With email') ?></a></li>
    </ul>
    <h2><?= __('Random maps') ?></h2>
    <ul>
        <?php
        foreach ($view['maps'] as $map) {
            echo "<li><a href='{$view['baseUrl']}/m/{$map['slug']}'>{$map['name']}</a></li>";
        }
        ?>
    </ul>
    <figure>
        <img src="/dist/mapamy-vision-home.png" alt="Mapamy">
    </figure>
    <?php
    include __DIR__ . '/partials/site-footer.php';
    ?>
</main>