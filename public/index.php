<?php
require __DIR__ . '/../init.php';

function requiresLogin(): void
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: /email-login');
        exit;
    }
}

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '', function () {
        require 'welcome.php';
    });
    $r->addRoute('GET', '/dashboard', function () {
        requiresLogin();
        require 'dashboard.php';
    });
    $r->addRoute('GET', '/create-map', function () {
        requiresLogin();
        require 'create-map.php';
    });
    $r->addRoute('POST', '/create-map', function () {
        requiresLogin();
        require 'create-map.php';
    });
    $r->addRoute('GET', '/create-pin/{id:\d+}', function ($vars) {
        requiresLogin();
        $_GET['id'] = $vars['id'];
        require 'create-pin.php';
    });
    $r->addRoute('POST', '/create-pin/{id:\d+}', function ($vars) {
        requiresLogin();
        $_GET['id'] = $vars['id'];
        require 'create-pin.php';
    });
    $r->addRoute('GET', '/edit-map/{id:\d+}', function ($vars) {
        requiresLogin();
        $_GET['id'] = $vars['id'];
        require 'edit-map.php';
    });
    $r->addRoute('POST', '/edit-map/{id:\d+}', function ($vars) {
        requiresLogin();
        $_GET['id'] = $vars['id'];
        require 'edit-map.php';
    });
    $r->addRoute('GET', '/edit-pin/{id:\d+}', function ($vars) {
        requiresLogin();
        $_GET['id'] = $vars['id'];
        require 'edit-pin.php';
    });
    $r->addRoute('POST', '/edit-pin/{id:\d+}', function ($vars) {
        requiresLogin();
        $_GET['id'] = $vars['id'];
        require 'edit-pin.php';
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
    $r->addRoute('GET', '/logout', function () {
        requiresLogin();
        require 'logout.php';
    });
    $r->addRoute('GET', '/m/{slug}', function ($vars) {
        $_GET['slug'] = $vars['slug'];
        require 'view-map.php';
    });
    $r->addRoute('GET', '/p/{slug}', function ($vars) {
        $_GET['slug'] = $vars['slug'];
        require 'view-pin.php';
    });
    $r->addRoute('GET', '/google-login', function () {
        require 'google-login.php';
    });
    $r->addRoute('GET', '/oauth-google-callback{params:.*}', function ($vars) {
        $_GET = array_merge($_GET, explode('/', $vars['params']));
        require 'oauth/google-callback.php';
    });
    $r->addRoute('POST', '/upload-editor-image/{map_id:\d+}', function ($vars) {
        requiresLogin();
        $_GET['map_id'] = $vars['map_id'];
        require 'upload-editor-image.php';
    });
    $r->addRoute('GET', '/image/{user_id:\d+}/{map_id:\d+}/{img_name}', function ($vars) {
        $_GET['user_id'] = $vars['user_id'];
        $_GET['map_id'] = $vars['map_id'];
        $_GET['img_name'] = $vars['img_name'];
        require 'serve-image.php';
    });
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = rtrim($_SERVER['REQUEST_URI'], '/');

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo 'Page not found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        http_response_code(405);
        echo 'Method not allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        call_user_func($handler, $vars);
        break;
}