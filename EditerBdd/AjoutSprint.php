<?php
////////Inserer info////////
try{
   $bdd = new PDO('mysql:host=localhost;dbname=scrum', 'root', '');
}
catch(Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}

$req = $bdd->prepare('INSERT INTO sprint (numero, dateDebut, dateFin) VALUES(?, ?, ?)');
$req->execute(array($_POST['numero'], $_POST['dateDebut'], $_POST['dateFin']));

header('Location: ../page2.php');
?>
