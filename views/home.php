<?php
if (!isset($view)) {
    exit('Data not passed to view');
}
?>
<main class="main">
    <p>You need to login:</p>
    <ul>
        <li><a href='<?php echo $view['baseUrl']; ?>/google-login'>Access with Google</a>: Login using your Google
            account
        </li>
        <li><a href='<?php echo $view['baseUrl']; ?>/email-login'>Access with email</a>: Login receiving a magic link
            via
            email
        </li>
    </ul>
</main>