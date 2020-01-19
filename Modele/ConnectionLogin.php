<?php 

session_start();

require_once('../Modele/Configs.php');

$EmployeLogin = $_POST['EmployeLogin'];
$PasswordInput = $_POST['inputPassword'];
$output = [];

//Recuperer le mdp chiffré du user qui essaie de se connecter
$statement = $connection->prepare(
    $sql = "SELECT E.mdp
    AS mdp
    FROM employe E
    WHERE E.mail like '$EmployeLogin'"
);
$statement->execute();
$result = $statement->fetch();

//Checker si le mdp rentré est le meme que celui de ce user chiffré dans la bdd et le renvoyé sur l'index avec ou sans message d'erreur
if (password_verify($PasswordInput, $result['mdp'])) {

    $statement = $connection->prepare(
        $sql = "SELECT E.id as id, E.prenom AS prenom, E.admin as admin
        From employe E 
        where E.mail like '$EmployeLogin'"
    );
    $statement->execute();
    $result = $statement->fetch();

    $_SESSION['IdUtilisateur'] = $result['id'];
    $_SESSION['PrenomUtilisateur'] = $result["prenom"];
    $_SESSION['Admin'] = $result["admin"];

    $output["Connexion"] = true;
    
} else {
    $output["Connexion"] = false;
}

print json_encode($output);
 