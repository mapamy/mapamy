<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
?>
<?php
if ($view['errorMessage']) {
    echo '<p>' . $view['errorMessage'] . '</p>';
}
?>
<form method="post">
    <label for="name">Map Name</label>
    <input type="text" name="name" id="name" required>
    <label for="description">Description</label>
    <textarea name="description" id="description" required></textarea>
    <button type="submit">Create Map</button>
</form>