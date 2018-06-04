<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\RoutingServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'dbname' => 'scrum',
        'user' => 'root',
        'password' => '',
        'host' => 'localhost',
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