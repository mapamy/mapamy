<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
?>
<main class="main">
    <h1>Mapamy</h1>
    <h2>Access</h2>
    <ul>
        <li><a href='<?php echo $view['baseUrl']; ?>/google-login'>With Google</a>
        </li>
        <li><a href='<?php echo $view['baseUrl']; ?>/email-login'>With email</a></li>
    </ul>
    <h2>Random maps</h2>
    <ul>
        <?php
        foreach ($view['maps'] as $map) {
            echo "<li><a href='{$view['baseUrl']}/m/{$map['slug']}'>{$map['name']}</a></li>";
        }
        ?>
    <?php
    include __DIR__ . '/partials/legal.php';
    ?>
</main>