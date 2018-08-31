<?php 

session_start();

require_once('../Modele/Configs.php');

$_SESSION['IdUtilisateur'] = $_POST['TypeEmployeOk'];
$IdUser = $_POST['TypeEmployeOk'];

$statement = $connection->prepare(
    $sql = "SELECT employe.prenom as prenom, (select nom from typeemploye where typeemploye.id = employe.id_TypeEmploye) as Type from employe where employe.id = $IdUser"
);
$statement->execute();
$result = $statement->fetch();

$_SESSION['PrenomUtilisateur'] = $result["prenom"];
$_SESSION['TypeUtilisateur'] = $result["Type"];

header('Location: ../index.php');

?>