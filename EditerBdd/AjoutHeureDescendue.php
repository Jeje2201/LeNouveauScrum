<?php
////////Inserer info////////
try{
   $bdd = new PDO('mysql:host=localhost;dbname=scrum', 'root', '');
}
catch(Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}

$req = $bdd->prepare('INSERT INTO heuresdescendues (heure, DateDescendu, id_Sprint, id_Employe, id_Projet) VALUES(?, ?, ?, ?, ?)');
$req->execute(array($_POST['nbheure'], $_POST['dateDebut'], $_POST['numerosprint'], $_POST['employeid'], $_POST['projetid']));

header('Location: ../page3.php');
?>
