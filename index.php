<?php

session_start();

require_once ('Modele/Configs.php');
require_once("Vues/header.html");

if(!isset($_SESSION['TypeUtilisateur']))
  require_once('Vues/Login.html');

else{

  require_once("Vues/NavBar.html");

  if(!isset($_REQUEST['vue']))
    $_REQUEST['vue'] = 'Accueil';

$vue = $_REQUEST['vue'];

switch($vue)
{

  case 'Accueil':
  require_once("Vues/Accueil.html");
  break;

  case 'Sprint':
  if($_SESSION['TypeUtilisateur'] == 'ScrumMaster')
  require_once("Vues/Sprints.html");
  break;

  case 'Planification':
  if($_SESSION['TypeUtilisateur'] == 'ScrumMaster')
  require_once("Vues/Planification.html");
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

  case 'MotDePasse':
  if($_SESSION['TypeUtilisateur'] == 'ScrumMaster')
  require_once("Vues/MotDePasseAdmin.html");
  break;

  case 'Interference':
  require_once("Vues/Interference.html");
  break;

  case 'GestionTache':
  if($_SESSION['TypeUtilisateur'] == 'ScrumMaster')
  require_once("Vues/Gestion_Tache.html");
  break;

  case 'GestionEmploye':
  if($_SESSION['TypeUtilisateur'] == 'ScrumMaster')
  require_once("Vues/Gestion_Employe.html");
  break;

  case 'GestionDemo':
  if($_SESSION['TypeUtilisateur'] == 'ScrumMaster')
  require_once("Vues/Gestion_Demo.html");
  break;

  case 'GestionProjet':
  if($_SESSION['TypeUtilisateur'] == 'ScrumMaster')
  require_once("Vues/Gestion_Projet.html");
  break;

  case 'GestionLogo':
  if($_SESSION['TypeUtilisateur'] == 'ScrumMaster')
  require_once("Vues/Gestion_Logo.html");
  break;

  case 'LabelObjectif':
  require_once("Vues/LabelObjectif.html");
  break;

  case 'GestionRemarque':
  if($_SESSION['TypeUtilisateur'] == 'ScrumMaster')
  require_once("Vues/Gestion_Remarque.html");
  break;

  default:
  print('<body class="fixed-nav sticky-footer" id="page-top"><div class="content-wrapper">
  <div class="container-fluid">JE CONNAIS PAS CETTE PAGE, TU ME DEMANDES "'. $vue .'" MAIS C\'EST QUOI AU JUSTE :((');
  break;
}
require_once("Vues/footer.html");
}

?>

