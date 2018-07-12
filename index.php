<?php

session_start();

require_once ('Modele/Configs.php');
require_once("Vues/header.html");

if(!isset($_SESSION['TypeUtilisateur']))
{
  require_once('Vues/Login.html');
}
else{

  if($_SESSION['TypeUtilisateur'] == 'ScrumMaster')
  {
    require_once("Vues/NavBarAdmin.html");

    if(!isset($_REQUEST['vue'])){
      $_REQUEST['vue'] = 'Dashboard';
    }
  }
  else
  {
   require_once("Vues/NavBarCommon.html");
   
   if(!isset($_REQUEST['vue'])){
    $_REQUEST['vue'] = 'Descendation';
  }
}

$vue = $_REQUEST['vue'];

switch($vue)
{
  case 'Dashboard':
  require_once("Vues/Dashboard.html");
  break;

  case 'yolo':
  require_once("Vues/Gestion_Sprint2.html");
  break;

  case 'test':
  require_once("Vues/PageTest.html");
  break;

  case 'Sprint':
  require_once("Vues/CreerSprint.html");
  break;

  case 'Attribution':
  require_once("Vues/AttributionHeures.html");
  break;

  case 'Descendation':
  if($_SESSION['TypeUtilisateur'] == 'ScrumMaster')
  {
    require_once("Vues/HeuresDescenduesAdmin.html");
  }
  else
  {
   require_once("Vues/HeuresDescendues.php");
 }
 break;

 case 'Burndownchart':
 require_once("Vues/BurnDownChart.html");
 break;

 case 'Objectifs':
 require_once("Vues/Objectifs.html");
 break;

 case 'Parametres':
 require_once("Vues/Gestion_Parametres.html");
 break;

 case 'Interferance':
 require_once("Vues/Interferance.html");
 break;

 case 'GestionDescendation':
 require_once("Vues/Gestion_HeuresDescendues.html");
 break;

 case 'GestionEmploye':
 require_once("Vues/Gestion_Employe.html");
 break;

 case 'GestionProjet':
 require_once("Vues/Gestion_Projet.html");
 break;

 default:
 print('<body class="fixed-nav sticky-footer" id="page-top"><div class="content-wrapper">
  <div class="container-fluid">JE CONNAIS PAS CETTE PAGE, TU ME DEMANDE "'. $vue .'" MAIS C\'EST QUOI AU JUSTE :((');
 break;
}

}

require_once("Vues/footer.html");

?>

