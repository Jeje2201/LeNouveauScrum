<?php 

session_start();

require_once('../Modele/Configs.php');

$_SESSION['IdUtilisateur'] = $_POST['TypeEmployeOk'];
$IdUser = $_POST['TypeEmployeOk'];
$PasswordInput = $_POST['inputPassword'];

//Recuperer le mdp chiffré du user qui essaie de se connecter
$statement = $connection->prepare(
    $sql = "SELECT employe.mdp as mdp from employe where employe.id = $IdUser"
);
$statement->execute();
$result = $statement->fetch();

//Checker si le mdp rentré est le meme que celui de ce user chiffré dans la bdd et le renvoyé sur l'index avec ou sans message d'erreur
if(password_verify($PasswordInput,$result['mdp'])){

$statement = $connection->prepare(
    $sql = "SELECT employe.prenom as prenom, (select nom from typeemploye where typeemploye.id = employe.id_TypeEmploye) as Type from employe where employe.id = $IdUser"
);
$statement->execute();
$result = $statement->fetch();

$_SESSION['PrenomUtilisateur'] = $result["prenom"];
$_SESSION['TypeUtilisateur'] = $result["Type"];

header('Location: ../index.php');
}
else{
    echo "<script type='text/javascript'>alert('Wrong Username or Password');
    window.location=' ../index.php';
    </script>";
}

?>