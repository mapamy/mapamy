<?php
session_start();

if (isset($_GET['language'])) {
    if (in_array($_GET['language'], ['en', 'es', 'fr', 'de', 'it'])) {
        $_SESSION['language'] = $_GET['language'];
    }
}

header('Location: /');