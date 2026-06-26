<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Support both local XAMPP and cPanel shared hosting layouts:
//   Local:  public/../vendor  (standard Laravel)
//   cPanel: public/../../laravel/vendor  (laravel app lives outside public_html)
if (file_exists(__DIR__ . '/../laravel/vendor/autoload.php')) {
    $laravelRoot = __DIR__ . '/../laravel';
} elseif (file_exists(__DIR__ . '/../../laravel/vendor/autoload.php')) {
    $laravelRoot = __DIR__ . '/../../laravel';
} else {
    $laravelRoot = __DIR__ . '/..';
}

if (file_exists($maintenance = $laravelRoot . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $laravelRoot . '/vendor/autoload.php';

/** @var Application $app */
$app = require_once $laravelRoot . '/bootstrap/app.php';

$app->handleRequest(Request::capture());
