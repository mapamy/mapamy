<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
?>
<p>Logged in with Email: <?php echo $view['email']; ?></p>
<ul>
    <li><a href='<?php echo $view['baseUrl']; ?>/create-map'>Create a map</a></li>
</ul>