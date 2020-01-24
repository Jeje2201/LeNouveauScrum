<?php

// Idée : 
// Créer la liste des vue seulement admin style ['planificatio','toto','tutu']
// Pas de case ou switch, seuelement un 
// if $vue est dans la liste de admin style, alors on check si admin, sinon on envoit dans tous les cas le "Vues/.$vue" car le nom doit correspondre au fichier

session_start();

require_once('Modele/Configs.php');
require_once("Vues/header.html");


if (!isset($_SESSION['Admin']) || !isset($_SESSION['IdUtilisateur']))
  require_once('Vues/Login.html');

else {

  //Si c'est en maintenance, cacher pour tout le monde a par pour l'id 22 (jeremy leriche)
  if ($Maintenance == 1 && $_SESSION['IdUtilisateur'] != 22) {
    require_once('Vues/Maintenance.html');
    return;
  }

  require_once("Vues/NavBar.html");

  //Si la vue n'existe pas (donc dans l'url on a un ?vues="" alors on met l'acceuil par défaut)
  if (!isset($_REQUEST['vue'])) {
    $vue =  'Accueil';
  }
  
  //Sinon on a une vue et on va la checker
  else {
    $vue = $_REQUEST['vue']; 
  }

    //Liste des pages visibles que par un admin
    $AdminOnly = array('Sprints', 'Planification', 'Gestion_Employe', 'Gestion_Projet', 'Gestion_Logo', 'Gestion_Demo', 'Gestion_Remarque','Gestion_FicheDeTemps', 'Gestion_FicheDeTempsPlus','ProjectInformation');

    //Si le chemin n'existe pas, l'indiquer à l'utilisateur
    if (!file_exists("Vues/" . $vue . ".html")) {
      print('<body class="fixed-nav sticky-footer" id="page-top"><div class="content-wrapper"><h1 class="container-fluid">La page n\'existe pas.</h1>');

      return;
    }

    //Si ma variable vue est dans ma variable admin, c'est que ce n'est destiné qu'aux admins
    if (in_array($vue, $AdminOnly)) {
      //si l'utilisateur est admin, on lui donne la vue
      if ($_SESSION['Admin']) {
        require_once("Vues/" . $vue . ".html");
      }
      
      //Sinon on lui dit qu'il n'a rien a faire ici
      else {
        print('<body class="fixed-nav sticky-footer" id="page-top"><div class="content-wrapper"><h1 class="container-fluid">Je ne sais pas comment tu es arrivé(e) là mais ce n\'est destiné qu\'aux admins. Tu n\'es pas le/la bienvenue ici.</h1>');
      }
    }
    
    //Si la page ne fait pas partie de admin seulement alors tout le monde peux y accéder sans prise de tete
    else {
      require_once("Vues/" . $vue . ".html");
    }

  require_once("Vues/footer.html");
}
