<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
?>
<main class="main">
    <?php
    include __DIR__ . '/partials/site-header.php';
    ?>
    <h2><?= __('Create map') ?></h2>
    <nav>
        <a href="/"><?= __('Cancel') ?></a>
    </nav>
    <?php
    if ($view['errorMessage']) {
        echo '<p>' . $view['errorMessage'] . '</p>';
    }
    ?>
    <form method="post" class="form">
        <div class="form-control">
            <label for="name"><?= __('Map name') ?></label>
            <input type="text" name="name" id="name" required>
        </div>
        <div class="form-control">
            <label for="description"><?= __('Description') ?></label>
            <textarea name="description" id="description"></textarea>
        </div>
        <div class="form-control">
            <label for="privacy"><?= __('Privacy') ?></label>
            <select id="privacy" name="privacy">
                <option value="1"><?= __('Public') ?></option>
                <option value="2"><?= __('Link only') ?></option>
                <option value="3"><?= __('Private') ?></option>
            </select>
        </div>
        <div class="form-control">
            <div class="g-recaptcha" data-sitekey="<?php echo $_ENV['RECAPTCHA_SITE_KEY']; ?>"></div>
        </div>
        <button type="submit" class="button"><?= __('Create map') ?></button>
    </form>
</main>