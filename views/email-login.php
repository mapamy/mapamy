<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
?>
<?php
if ($view['loginLinkSent']) {
    ?>
    <p>An email has been sent with a login link. Click on the link to log in.</p>
    <?php
} else {
    if ($view['errorMessage']) {
        echo '<p>' . $view['errorMessage'] . '</p>';
    }
    ?>
    <form method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
        <button type="submit">Send me a login link</button>
    </form>
    <?php
}
?>