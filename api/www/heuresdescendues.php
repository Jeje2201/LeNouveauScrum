<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

$app->get('/heuresdescendues/LaListeGeneral/{numero}', function ($numero) use ($app) {
    $qb = $app['db']->createQueryBuilder('');

    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=scrum;charset=utf8', 'root', '');
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }

    $sql = "select heuresdescendues.heure as NbHeure, heuresdescendues.DateDescendu as date, projet.nom as projet, employe.prenom as employe FROM heuresdescendues inner JOIN employe ON heuresdescendues.id_Employe = employe.id INNER JOIN projet on projet.id = heuresdescendues.id_Projet INNER JOIN sprint on sprint.id = heuresdescendues.id_Sprint WHERE id_sprint= $numero ORDER BY heuresdescendues.id desc";
    
    $tmpQuery = $bdd->prepare($sql);
    $tmpQuery->execute();

    $result = $tmpQuery->fetchAll();

    $NbHeure = [];
    $date = [];
    $projet = [];
    $employe = [];

    foreach ($result as $row) {
       
       $NbHeure[] = $row['NbHeure'];
       $date[] = $row['date'];
       $projet[] = $row['projet'];
       $employe[] = $row['employe'];
       
    }
    
    $toReturn[] = $NbHeure;
    $toReturn[] = $date;
    $toReturn[] = $projet;
    $toReturn[] = $employe;
    
    return $app->json($toReturn);
})->bind('get_total');

///////////////////////////////////

$app->get('/heuresdescendues/LaListeParJour/{numero}', function ($numero) use ($app) {
    $qb = $app['db']->createQueryBuilder('');

    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=scrum;charset=utf8', 'root', '');
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }

    $sql = "select  sprint.id as Sprint, sum(heuresdescendues.heure) as totHeure, heuresdescendues.DateDescendu as date
                                    FROM heuresdescendues inner JOIN employe ON heuresdescendues.id_Employe = employe.id
                                    INNER JOIN sprint on sprint.id = heuresdescendues.id_Sprint
                                    where id_sprint=$numero
                                    GROUP BY sprint.id, heuresdescendues.DateDescendu";
    
    $tmpQuery = $bdd->prepare($sql);
    $tmpQuery->execute();

    $result = $tmpQuery->fetchAll();

    $totHeure = [];
    $date = [];

    foreach ($result as $row) {
       $totHeure[] = $row['totHeure'];
       $date[] = $row['date'];
    }
    
    $toReturn[] = $totHeure;
    $toReturn[] = $date;
    
    return $app->json($toReturn);
})->bind('get_parjour');

///////////////////////////////////

$app->get('/heuresdescendues/LaListeTotal/{numero}', function ($numero) use ($app) {
    $qb = $app['db']->createQueryBuilder('');

    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=scrum;charset=utf8', 'root', '');
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }

    $sql = "select sum(heuresdescendues.heure) as totHeure
            FROM heuresdescendues inner JOIN employe ON heuresdescendues.id_Employe = employe.id
            INNER JOIN sprint on sprint.id = heuresdescendues.id_Sprint
            where id_sprint= $numero
            GROUP BY sprint.id";
    
    $tmpQuery = $bdd->prepare($sql);
    $tmpQuery->execute();

    $result = $tmpQuery->fetchAll();

    $totHeure = [];

    foreach ($result as $row) {
       $totHeure[] = $row['totHeure'];
    }
    
    $toReturn[] = $totHeure;
    
    return $app->json($toReturn);
})->bind('get_entout');