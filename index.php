<?php

session_start();

require_once ('Modele/Configs.php');
require_once("Vues/Header.html");

if(!isset($_SESSION['TypeUtilisateur']))
  require_once('Vues/Login.html');

else{

  require_once("Vues/NavBar.html");

  if(!isset($_REQUEST['vue']))
    $_REQUEST['vue'] = 'Dashboard';

$vue = $_REQUEST['vue'];

switch($vue)
{

  case 'News':
  require_once("Vues/News.html");
  break;

  case 'Dashboard':
  require_once("Vues/Dashboard.html");
  break;

  case 'Sprint':
   if($_SESSION['TypeUtilisateur'] == 'ScrumMaster')
  require_once("Vues/Sprints.html");
  break;

  case 'Attribution':
   if($_SESSION['TypeUtilisateur'] == 'ScrumMaster')
  require_once("Vues/Planification.html");
  break;

  case 'Descendation':
   require_once("Vues/HeuresDescendues.html");
 break;

 case 'Objectifs':
 require_once("Vues/Retrospective.html");
 break;

 case 'Parametres':
 require_once("Vues/Parametres.html");
 break;

 case 'Interferance':
 require_once("Vues/Interferance.html");
 break;

 case 'GestionDescendation':
  if($_SESSION['TypeUtilisateur'] == 'ScrumMaster')
 require_once("Vues/Gestion_HeuresDescendues.html");
 break;

 case 'GestionEmploye':
 if($_SESSION['TypeUtilisateur'] == 'ScrumMaster')
 require_once("Vues/Gestion_Employe.html");
 break;

 case 'GestionProjet':
  if($_SESSION['TypeUtilisateur'] == 'ScrumMaster')
 require_once("Vues/Gestion_Projet.html");
 break;

  case 'ConversionObjectif':
  if($_SESSION['TypeUtilisateur'] == 'ScrumMaster')
 require_once("Vues/ConversionObjectif.html");
 break;

  case 'LabelObjectif':
 require_once("Vues/LabelObjectif.html");
 break;

 default:
 print('<body class="fixed-nav sticky-footer" id="page-top"><div class="content-wrapper">
  <div class="container-fluid">JE CONNAIS PAS CETTE PAGE, TU ME DEMANDE "'. $vue .'" MAIS C\'EST QUOI AU JUSTE :((');
 break;
}
require_once("Vues/Footer.html");
}



?>

