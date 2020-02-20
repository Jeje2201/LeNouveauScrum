<?php 

session_start();

require_once('Configs.php');

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

//Si ne trouve pas de mot de passe pour le mail donné
if($result == false){
    header($_SERVER["SERVER_PROTOCOL"].' 500 '.utf8_decode('Mail non reconnue'));
}

//Checker si le mdp rentré est le meme que celui de ce user chiffré dans la bdd et le renvoyé sur l'index avec ou sans message d'erreur
else{
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
        $_SESSION['user']['nom'] = $result["user_nom"];
        $_SESSION['user']['admin'] = $result["user_admin"];
        $_SESSION['user']['registerDate'] = $result["user_registerDate"];

        $output["Connexion"] = true;
        
        } else {
            header($_SERVER["SERVER_PROTOCOL"].' 500 '.utf8_decode('Mot de passe incorrect'));
    }
}

print json_encode($output);
 