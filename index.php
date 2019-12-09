<?php

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


  if (!isset($_REQUEST['vue']))
    $_REQUEST['vue'] = 'Accueil';

  $vue = $_REQUEST['vue'];
  $notAdminMsg = '<body class="fixed-nav sticky-footer" id="page-top"><div class="content-wrapper"><h1 class="container-fluid">Je ne sais pas comment tu es arrivé(e) là mais ce n\'est destiné qu\'aux admins. Tu n\'es pas le/la bienvenue ici.</h1>';

  switch ($vue) {

    case 'Accueil':
      require_once("Vues/Accueil.html");
      break;

    case 'Sprint':
      if ($_SESSION['Admin'])
        require_once("Vues/Sprints.html");
      else
        print($notAdminMsg);
      break;

    case 'Planification':
      if ($_SESSION['Admin'])
        require_once("Vues/Planification.html");
      else
        print($notAdminMsg);
      break;

    case 'Tache':
      require_once("Vues/Tache.html");
      break;

    case 'Objectifs':
      require_once("Vues/Retrospective.html");
      break;

    case 'Personnalisation':
      require_once("Vues/Personnalisation.html");
      break;

    case 'FicheDeTemps':
      require_once("Vues/FicheDeTemps.html");
      break;

    case 'MotDePasse':
      if ($_SESSION['Admin'])
        require_once("Vues/MotDePasseAdmin.html");
      else
        print($notAdminMsg);
      break;

    case 'Interference':
      require_once("Vues/Interference.html");
      break;

    case 'Achievement':
      require_once("Vues/Achievement.html");
      break;

    case 'GestionTache':
      if ($_SESSION['Admin'])
        require_once("Vues/Gestion_Tache.html");
      else
        print($notAdminMsg);
      break;

    case 'GestionEmploye':
      if ($_SESSION['Admin'])
        require_once("Vues/Gestion_Employe.html");
      else
        print($notAdminMsg);
      break;

    case 'GestionDemo':
      if ($_SESSION['Admin'])
        require_once("Vues/Gestion_Demo.html");
      else
        print($notAdminMsg);
      break;

    case 'GestionProjet':
      if ($_SESSION['Admin'])
        require_once("Vues/Gestion_Projet.html");
      else
        print($notAdminMsg);
      break;

    case 'GestionLogo':
      if ($_SESSION['Admin'])
        require_once("Vues/Gestion_Logo.html");
      else
        print($notAdminMsg);
      break;

    case 'GestionFicheDeTemps':
      if ($_SESSION['Admin'])
        require_once("Vues/Gestion_FicheDeTemps.html");
      else
        print($notAdminMsg);
      break;

    case 'GestionFicheDeTempsPlus':
      if ($_SESSION['Admin'])
        require_once("Vues/Gestion_FicheDeTempsPlus.html");
      else
        print($notAdminMsg);
      break;

    case 'Bienvenue':
      require_once("Vues/Bienvenue.html");
      break;

    case 'LabelObjectif':
      require_once("Vues/LabelObjectif.html");
      break;

    case 'GestionRemarque':
      if ($_SESSION['Admin'])
        require_once("Vues/Gestion_Remarque.html");
      else
        print($notAdminMsg);
      break;

    default:
      print('<body class="fixed-nav sticky-footer" id="page-top"><div class="content-wrapper">
  <div class="container-fluid">JE CONNAIS PAS CETTE PAGE, TU ME DEMANDES "' . $vue . '" MAIS C\'EST QUOI AU JUSTE :((');
      break;
  }
  require_once("Vues/footer.html");
}
