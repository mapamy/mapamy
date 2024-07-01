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