<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

$app->get('/projets', function () use ($app) {
    
    $qb = $app['db']->createQueryBuilder('');
    $qb
        ->select('*')
        ->from('projet', 's')
    ;
    
    $res = $qb->execute()->fetchAll();
    
    return $app->json($res);
});

$app->post('/projets', function (Request $request) use ($app) {
    $data = json_decode($request->getContent(), true);
    
    $qb = $app['db']->createQueryBuilder();
    $qb
        ->insert('projet')
        ->values(
            array(
                'numero' => ':numero',
            )
        )
        ->setParameter(':numero', $data['numero'])
    ;
    
    $qb->execute();
    $id = $app['db']->lastInsertId();
    
    $res = array(
        'path' => $app['url_generator']->generate('get_projets', array('id' => $id)),
        'id' => $id,
    );
    
    return $app->json($res);
});

$app->get('/projets/{id}', function ($id) use ($app) {
$qb = $app['db']->createQueryBuilder('');
    $qb = $qb
        ->select('*')
        ->from('projet', 's')
        ->where('id = :id')->setParameter('id', $id);
    ;
    
    $res = $qb->execute()->fetchAll();
    
    if (count($res) < 1) {
        $app->abort(404, "Project $id does not exist.");
    }
    
    return $app->json($res[0]);
})->bind('get_projet');
