<?php 

session_start();

require_once('../Modele/Configs.php');

$_SESSION['IdUtilisateur'] = $_POST['TypeEmployeOk'];
$IdUser = $_POST['TypeEmployeOk'];
$PasswordInput = $_POST['inputPassword'];

//Recuperer le mdp chiffré du user qui essaie de se connecter
$statement = $connection->prepare(
    $sql = "SELECT E.mdp
    AS mdp
    FROM employe E
    WHERE E.id = $IdUser"
);
$statement->execute();
$result = $statement->fetch();

//Checker si le mdp rentré est le meme que celui de ce user chiffré dans la bdd et le renvoyé sur l'index avec ou sans message d'erreur
if(password_verify($PasswordInput,$result['mdp'])){

$statement = $connection->prepare(
    $sql = "SELECT E.prenom AS prenom,
    (
        select T.nom FROM typeemploye T
        WHERE T.id = E.id_TypeEmploye
    ) AS LeType
    FROM employe E WHERE E.id = $IdUser"
);
$statement->execute();
$result = $statement->fetch();

$_SESSION['PrenomUtilisateur'] = $result["prenom"];
$_SESSION['TypeUtilisateur'] = $result["LeType"];

header('Location: ../index.php');
}
else{
    echo "<script type='text/javascript'>alert('Mhm.. Jérémy a pourtant bien codé l\'application, et ce mot de passe semble ne pas correspondre. Se référer à un ScrumMaster qui pourrait le re-définir semble être la meilleur solution :\)');
    window.location=' ../index.php';
    </script>";
}


?>