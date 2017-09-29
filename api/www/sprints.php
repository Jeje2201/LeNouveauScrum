<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

$app->get('/sprints', function () use ($app) {
    
    $qb = $app['db']->createQueryBuilder('');
    $qb
        ->select('*')
        ->from('sprint', 's')
    ;
    
    $res = $qb->execute()->fetchAll();
    
    return $app->json($res);
});

$app->post('/sprints', function (Request $request) use ($app) {
    $data = json_decode($request->getContent(), true);
    
    $qb = $app['db']->createQueryBuilder();
    $qb
        ->insert('sprint')
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
        'path' => $app['url_generator']->generate('get_sprint', array('id' => $id)),
        'id' => $id,
    );
    
    return $app->json($res);
});

$app->get('/sprints/{numero}', function ($numero) use ($app) {
$qb = $app['db']->createQueryBuilder('');
    $qb
        ->select('*')
        ->from('sprint', 's')
        ->where('numero = :numero')->setParameter('numero', $numero)
    ;
    
    $res = $qb->execute()->fetchAll();
    
    if (count($res) < 1) {
        $app->abort(404, "Sprint $id does not exist.");
    }
    
    return $app->json($res[0]);
})->bind('get_sprint');