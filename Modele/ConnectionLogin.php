<?php 

session_start();

$_SESSION['Utilisateur']=$_POST['TypeEmployeOk'];

header('Location: ../index.php');

?>