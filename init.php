<?php
/**
 * Initialize App, here we load classes,
 * setup env variables and start a session.
 */

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

session_start();

// Set default language if not set
if (!isset($_SESSION['language'])) {
    $tryLang = $_COOKIE['language'] ?? null;

    $headers = getallheaders();
    if (isset($headers['Accept-Language'])) {
        $tryLang = substr($headers['Accept-Language'], 0, 2);
    }

    // Validate the language
    $supportedLangs = ['en', 'es', 'fr', 'de', 'it'];
    if (!in_array($tryLang, $supportedLangs)) {
        $tryLang = 'en'; // Default language
    }

    $_SESSION['language'] = $tryLang;
    setcookie('language', $tryLang, time() + (86400 * 365), "/");
}

/**
 * Simple translation function
 * Fact: $_SESSION['language'] is set and restricted to existing filename
 * @param $key
 * @return mixed
 */
function __($key)
{
    if ($_SESSION['language'] === 'en') {
        return $key;
    }
    static $lang = null;
    if ($lang === null) {
        $lang = include __DIR__ . '/languages/' . $_SESSION['language'] . '.php';
    }
    return $lang[$key] ?? $key;
}