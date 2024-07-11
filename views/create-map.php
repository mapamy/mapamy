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
<form method="post" class="form">
    <div class="form-control">
        <label for="name">Map Name</label>
        <input type="text" name="name" id="name" required>
    </div>
    <div class="form-control">
        <label for="wysiwyg">Content</label>
        <textarea name="wysiwyg" id="wysiwyg"></textarea>
    </div>
    <div class="form-control">
        <label for="privacy">Privacy</label>
        <select id="privacy" name="privacy">
            <option value="1">Public</option>
            <option value="2">Link only</option>
            <option value="3">Private</option>
        </select>
    </div>
    <button type="submit" class="button">Create Map</button>
</form>