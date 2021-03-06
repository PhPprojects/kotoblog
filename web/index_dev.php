<?php

define('KOTOBLOG_PUBLIC_ROOT', __DIR__);

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

require __DIR__ . '/../app/config/dev.php';
require __DIR__ . '/../src/app.php';
require __DIR__ . '/../src/routes.php';

$request = \Kotoblog\Request::createFromGlobals();
$app->run($request);
