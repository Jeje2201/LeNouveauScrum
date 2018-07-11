<?php 

session_start();

$TemporaryString = explode("|",$_POST['TypeEmployeOk']);
$_SESSION['TypeUtilisateur'] = $TemporaryString[0];
$_SESSION['IdUtilisateur'] = $TemporaryString[1];
$_SESSION['PrenomUtilisateur'] =$TemporaryString[2];


header('Location: ../index.php');

?>