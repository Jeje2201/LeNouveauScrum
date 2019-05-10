<?php 

session_start();

require_once('../Modele/Configs.php');

$_SESSION['IdUtilisateur'] = $_POST['TypeEmployeOk'];
$IdUser = $_POST['TypeEmployeOk'];
$PasswordInput = $_POST['inputPassword'];
$output = [];

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
if (password_verify($PasswordInput, $result['mdp'])) {

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

    $output["Connexion"] = true;
    
} else {
    $output["Connexion"] = false;
}

echo json_encode($output);
 