<?php

require_once __Dir__.'/../vendor/autoload.php';

require 'Configs.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\RoutingServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
    ),
));

require_once('./sprints.php');
require_once('./employes.php');
require_once('./projets.php');
require_once('./burndownchart.php');
require_once('./heuresdescendues.php');
require_once('./heuresattribues.php');

$app['debug'] = true;

$app->run();
?>