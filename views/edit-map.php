<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
$mapData = $view['mapData'];
?>
<?php
if (isset($view['errorMessage'])) {
    echo '<p>' . $view['errorMessage'] . '</p>';
}
?>
<form method="post" class="form">
    <div class="form-control">
        <label for="name">Map Name</label>
        <input type="text" id="name" name="name" required
               value="<?php echo htmlspecialchars($mapData['name'] ?? ''); ?>">
    </div>
    <div class="form-control">
        <label for="slug">Slug</label>
        <input type="text" id="slug" name="slug" required
               value="<?php echo htmlspecialchars($mapData['slug'] ?? ''); ?>">
    </div>
    <div class="form-control">
        <label for="description">Description</label>
        <textarea name="description" id="description"><?php echo htmlspecialchars($mapData['description'] ?? ''); ?></textarea>
    </div>
    <div class="form-control">
        <label for="wysiwyg">Content</label>
        <textarea name="wysiwyg" id="wysiwyg"
                  data-map-id="<?php echo $mapData['id']; ?>"><?php echo $mapData['wysiwyg'] ?? ''; ?></textarea>
    </div>
    <div class="form-control">
        <label for="privacy">Privacy</label>
        <select id="privacy" name="privacy">
            <option value="1">Public</option>
            <option value="2">Link only</option>
            <option value="3">Private</option>
        </select>
    </div>
    <button type="submit" class="button">Update Map</button>
</form>
<script>