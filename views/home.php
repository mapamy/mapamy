<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
?>
<main class="main">
    <?php
    include __DIR__ . '/partials/site-header.php';
    ?>
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
        <?php
        include __DIR__ . '/partials/site-footer.php';
        ?>
</main>