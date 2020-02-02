<?php 

session_start();

require_once('../Modele/Configs.php');

$EmployeLogin = $_POST['EmployeLogin'];
$PasswordInput = $_POST['inputPassword'];
$output = [];

//Recuperer le mdp chiffré du user qui essaie de se connecter
$statement = $connection->prepare(
    $sql = "SELECT user_mdp
    FROM user
    WHERE user_mail like '$EmployeLogin'"
);
$statement->execute();
$result = $statement->fetch();

//Checker si le mdp rentré est le meme que celui de ce user chiffré dans la bdd et le renvoyé sur l'index avec ou sans message d'erreur
if (password_verify($PasswordInput, $result['user_mdp'])) {

    $statement = $connection->prepare(
        $sql = "SELECT *
        From user 
        where user_mail like '$EmployeLogin'"
    );
    $statement->execute();
    $result = $statement->fetch();

    $_SESSION['user']['id'] = $result['user_pk'];
    $_SESSION['user']['prenom'] = $result["user_prenom"];
    $_SESSION['user']['admin'] = $result["user_admin"];
    $_SESSION['user']['registerDate'] = $result["user_registerDate"];

    $output["Connexion"] = true;
    
} else {
    $output["Connexion"] = false;
}

print json_encode($output);
 