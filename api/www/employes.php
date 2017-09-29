<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

$app->get('/employes', function () use ($app) {
    
    $qb = $app['db']->createQueryBuilder('');
    $qb
        ->select('*')
        ->from('employe', 's')
    ;
    
    $res = $qb->execute()->fetchAll();
    
    return $app->json($res);
});

$app->post('/employes', function (Request $request) use ($app) {
    $data = json_decode($request->getContent(), true);
    
    $qb = $app['db']->createQueryBuilder();
    $qb
        ->insert('employes')
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
        'path' => $app['url_generator']->generate('get_employes', array('id' => $id)),
        'id' => $id,
    );
    
    return $app->json($res);
});

$app->get('/employes/{id}', function ($id) use ($app) {
$qb = $app['db']->createQueryBuilder('');
    $qb = $qb
        ->select('*')
        ->from('employe', 's')
        ->where('id = :id')->setParameter('id', $id);
    ;
    
    $res = $qb->execute()->fetchAll();
    
    if (count($res) < 1) {
        $app->abort(404, "Employe $id does not exist.");
    }
    
    return $app->json($res[0]);
})->bind('get_employee');