<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
?>
<main class="main">
    <?php
    include __DIR__ . '/partials/site-header.php';
    ?>
    <h2><?= __('Login via email') ?></h2>
    <nav>
        <a href="/"><?= __('Cancel') ?></a>
    </nav>
    <?php
    if ($view['loginLinkSent']) {
        ?>
        <p><?= __('An email has been sent with a login link. Click on the link to log in') ?>.</p>
        <?php
    } else {
        if ($view['errorMessage']) {
            echo '<p>' . $view['errorMessage'] . '</p>';
        }
        ?>
        <form method="post" class="form">
            <div class="form-control">
                <label for="email"><?= __('Email') ?></label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-control">
                <div class="g-recaptcha" data-sitekey="<?php echo $_ENV['RECAPTCHA_SITE_KEY']; ?>"></div>
            </div>
            <div class="form-control">
                <button type="submit" class="button button--green"><?= __('Send me a login link') ?></button>
            </div>
        </form>
        <?php
    }
    ?>
</main>
