<?php
require_once "vendor/autoload.php";

$app = new \Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

// definido para carregar o css no twig
$app['asset_path'] = 'http://localhost';