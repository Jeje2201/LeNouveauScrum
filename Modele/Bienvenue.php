<?php

session_start();
require_once('Configs.php');

if (isset($_POST["action"])) {

  if ($_POST["action"] == "ListeProjets") {
    $output = array();
    $statement = $connection->prepare(
      "SELECT projet.projet_pk, 
      projet.projet_nom, 
      user.user_prenom, 
      user.user_nom, 
      projet.projet_description, 
      client.client_nom, 
      client.client_entreprise,
      client.client_job
      FROM `projet_ressource`
      inner join user on user.user_pk = projet_ressource.projet_ressource_fk_user
      inner join projet on projet.projet_pk = projet_ressource.projet_ressource_fk_projet
      inner join client on projet.projet_fk_client = client.client_pk
      -- inner join projet_technologie on projet_technologie.projet_technologie_fk_projet = projet_ressource.projet_ressource_fk_projet
      where projet.projet_actif = 2
      and user.user_actif = 1
      order by projet_nom"
    );
    $statement->execute();
    $result = $statement->fetchAll();

    $resultat = [];
    $Projet = "";

    foreach ($result as $key => $row) {

      if( isset($UnProjet) && ( $row['projet_nom'] != $Projet || $key+1 == count($result) ) ){
        array_push($resultat, $UnProjet);
      }

      if($row['projet_nom'] != $Projet){

        $Projet = $row['projet_nom'];

        $UnProjet = [];
        $UnProjet['projet_pk'] = $row['projet_pk'];
        $UnProjet['projet_nom'] = $row['projet_nom'];
        $UnProjet['Ressource'] = [];
        $UnProjet['projet_description'] = $row['projet_description'];
        $UnProjet['client_nom'] = $row['client_nom'];
        $UnProjet['client_entreprise'] = $row['client_entreprise'];
        $UnProjet['client_job'] = $row['client_job'];
        
      }

      $UneRessource = [];
      $UneRessource['user_prenom'] = $row['user_prenom'];
      $UneRessource['user_nom'] = $row['user_nom'];
      array_push($UnProjet['Ressource'],$UneRessource);

    }

    echo json_encode($resultat);

  }
}
?> 