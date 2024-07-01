<?php
require __DIR__ . '/../init.php';

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '', function () {
        require 'welcome.php';
    });
    $r->addRoute('GET', '/dashboard', function () {
        require 'dashboard.php';
    });
    $r->addRoute('GET', '/create-map', function () {
        require 'create-map.php';
    });
    $r->addRoute('POST', '/create-map', function () {
        require 'create-map.php';
    });
    $r->addRoute('GET', '/create-pin/{map:\d+}', function ($vars) {
        $_GET['map'] = $vars['map'];
        require 'create-pin.php';
    });
    $r->addRoute('POST', '/create-pin/{map:\d+}', function ($vars) {
        $_GET['map'] = $vars['map'];
        require 'create-pin.php';
    });
    $r->addRoute('GET', '/edit-map/{id:\d+}', function ($vars) {
        $_GET['id'] = $vars['id'];
        require 'edit-map.php';
    });
    $r->addRoute('GET', '/email-login', function () {
        require 'email-login.php';
    });
    $r->addRoute('POST', '/email-login', function () {
        require 'email-login.php';
    });
    $r->addRoute('GET', '/email-login{params:.*}', function ($vars) {
        $_GET = array_merge($_GET, explode('/', $vars['params']));
        require 'email-login.php';
    });
    $r->addRoute('GET', '/google-login', function () {
        require 'google-login.php';
    });
    $r->addRoute('GET', '/logout', function () {
        require 'logout.php';
    });
    $r->addRoute('GET', '/show-insta', function () {
        require 'show-insta.php';
    });
    $r->addRoute('GET', '/m/{slug}', function ($vars) {
        $_GET['slug'] = $vars['slug'];
        require 'view-map.php';
    });
    $r->addRoute('GET', '/oauth/google-callback.php{params:.*}', function ($vars) {
        $_GET = array_merge($_GET, explode('/', $vars['params']));
        require 'oauth/google-callback.php';
    });
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = rtrim($_SERVER['REQUEST_URI'], '/');

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        http_response_code(404);
        echo 'Page not found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        http_response_code(405);
        echo 'Method not allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        call_user_func($handler, $vars);
        break;
}