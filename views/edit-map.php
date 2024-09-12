<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
$mapData = $view['mapData'];
?>
<main class="main">
    <?php
    include __DIR__ . '/partials/site-header.php';
    ?>
    <h2><?= __('Edit map') ?></h2>
    <nav>
        <a href="/m/<?php echo $mapData['slug']; ?>"><?= __('Back to map') ?></a>
        <a href="/create-pin/<?php echo $mapData['id']; ?>"><?= __('Add pin') ?></a>
    </nav>
    <?php
    if (isset($view['errorMessage'])) {
        echo '<p>' . $view['errorMessage'] . '</p>';
    }
    ?>
    <form method="post" class="form">
        <div class="form-control">
            <label for="name"><?= __('Map name') ?></label>
            <input type="text" id="name" name="name" required
                   value="<?php echo htmlspecialchars($mapData['name'] ?? ''); ?>">
        </div>
        <div class="form-control">
            <label for="slug"><?= __('Slug') ?></label>
            <input type="text" id="slug" name="slug" required
                   value="<?php echo htmlspecialchars($mapData['slug'] ?? ''); ?>">
        </div>
        <div class="form-control">
            <label for="description"><?= __('Description') ?></label>
            <textarea name="description"
                      id="description"><?php echo htmlspecialchars($mapData['description'] ?? ''); ?></textarea>
        </div>
        <div class="form-control">
            <label for="wysiwyg"><?= __('Content') ?></label>
            <textarea name="wysiwyg" id="wysiwyg"
                      data-map-id="<?php echo $mapData['id']; ?>"><?php echo $mapData['wysiwyg'] ?? ''; ?></textarea>
        </div>
        <div class="form-control">
            <label for="privacy"><?= __('Privacy') ?></label>
            <select id="privacy" name="privacy">
                <option value="1"><?= __('Public') ?></option>
                <option value="2"><?= __('Link only') ?></option>
                <option value="3"><?= __('Private') ?></option>
            </select>
        </div>
        <button type="submit" class="button button--green"><?= __('Update map') ?></button>
    </form>
</main>