<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
?>
<main class="main">
    <h1>Mapamy</h1>
    <h2>Create map</h2>
    <nav>
        <a href="/">Home</a>
    </nav>
    <?php
    if ($view['errorMessage']) {
        echo '<p>' . $view['errorMessage'] . '</p>';
    }
    ?>
    <form method="post" class="form">
        <div class="form-control">
            <label for="name">Map Name</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div class="form-control">
            <label for="description">Description</label>
            <textarea name="description" id="description"></textarea>
        </div>
        <div class="form-control">
            <label for="privacy">Privacy</label>
            <select id="privacy" name="privacy">
                <option value="1">Public</option>
                <option value="2">Link only</option>
                <option value="3">Private</option>
            </select>
        </div>
        <div class="form-control">
            <div class="g-recaptcha" data-sitekey="<?php echo $_ENV['RECAPTCHA_SITE_KEY']; ?>"></div>
        </div>
        <button type="submit" class="button">Create Map</button>
    </form>
</main>