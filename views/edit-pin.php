<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
$mapData = $view['mapData'];
$pinData = $view['pinData'];
?>
<?php
if (isset($view['errorMessage'])) {
    echo '<p>' . $view['errorMessage'] . '</p>';
}
?>
<form method="post" class="form">
    <div class="form-control">
        <label for="name">Pin Name</label>
        <input type="text" id="name" name="name" required
               value="<?php echo htmlspecialchars($pinData['name'] ?? ''); ?>">
    </div>
    <div class="form-control">
        <label for="slug">Slug</label>
        <input type="text" id="slug" name="slug" required
               value="<?php echo htmlspecialchars($pinData['slug'] ?? ''); ?>">
    </div>
    <div class="form-control">
        <label for="description">Description</label>
        <textarea name="description" id="description"><?php echo htmlspecialchars($pinData['description'] ?? ''); ?></textarea>
    </div>
    <div class="form-control">
        <label for="wysiwyg">Content</label>
        <textarea name="wysiwyg" id="wysiwyg"
                  data-map-id="<?php echo $mapData['id']; ?>"><?php echo $pinData['content'] ?? ''; ?></textarea>
    </div>
    <div class="form-group">
        <label for="latitude">Latitude</label>
        <input type="text" id="latitude" name="latitude" required
               value="<?php echo htmlspecialchars($pinData['latitude'] ?? ''); ?>">
    </div>
    <div class="form-group">
        <label for="longitude">Longitude</label>
        <input type="text" id="longitude" name="longitude" required
               value="<?php echo htmlspecialchars($pinData['longitude'] ?? ''); ?>">
    </div>
    <button type="submit" class="button">Update Pin</button>
</form>