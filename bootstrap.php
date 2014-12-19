<?php
require_once "vendor/autoload.php";

$app = new \Silex\Application();
$app['debug'] = true;

$app['conn'] = include __DIR__.'/config/connectionDB.php';