<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

$app->get('/action/gethouratt/{numero}', function ($numero) use ($app) {
    $qb = $app['db']->createQueryBuilder('');

    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=scrum;charset=utf8', 'root', '');
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }

    $sql = "select $numero as Sprint, attribution.heure as NbHeure, projet.nom as projet, employe.prenom as employe FROM attribution inner JOIN employe ON employe.id = attribution.id_Employe INNER JOIN projet ON projet.id = attribution.id_Projet INNER JOIN sprint ON sprint.id = attribution.id_Sprint where id_sprint=$numero ORDER BY attribution.id DESC ";
    
    $tmpQuery = $bdd->prepare($sql);
    $tmpQuery->execute();

    $result = $tmpQuery->fetchAll();

    $nbheure = [];
    $employe = [];
    $projet = [];

    foreach ($result as $row) {
       $nbheure[] = $row['NbHeure'];
       $employe[] = $row['employe'];
       $projet[] = $row['projet'];
    }
    if (!$nbheure && !$employe && !$projet ){
         $app->abort(404, "Le Sprint n°$numero manque de données pour afficher le tableau" );
    }
    
    $toReturn[] = $employe;
    $toReturn[] = $projet;
    $toReturn[] = $nbheure;
    
    return $app->json($toReturn);
})->bind('get_hatt');


$app->get('/action/gettothouratt/{numero}', function ($numero) use ($app) {
    $qb = $app['db']->createQueryBuilder('');

    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=scrum;charset=utf8', 'root', '');
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }

    $sql = "select sum(attribution.heure) as totHeure FROM attribution INNER JOIN sprint on sprint.id = attribution.id_Sprint where id_sprint=$numero GROUP BY sprint.id";
    
    $tmpQuery = $bdd->prepare($sql);
    $tmpQuery->execute();

    $result = $tmpQuery->fetchAll();

    $totheure = [];

    foreach ($result as $row) {
       $totheure[] = $row['totHeure'];
    }
    if (!$totheure ){
         $app->abort(404, "Le Sprint n°$numero manque de données pour afficher le tableau" );
    }
    
    $toReturn[] = $totheure;
    
    return $app->json($toReturn);
})->bind('get_tothatt');