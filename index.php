<?php

session_start();

require_once ('Modele/Configs.php');
require_once("Vues/header.php");

if(!isset($_REQUEST['vue']))
{
    $_REQUEST['vue'] = 'Acceuil';
}

$vue = $_REQUEST['vue'];

switch($vue)
{
    case 'Acceuil':
        require_once("Vues/Dashboard.php");
  break;

    case 'Sprint':
        require_once("Vues/CreerSprint.php");
  break;

    case 'Attribution':
        require_once("Vues/AttributionHeures.php");
  break;

  case 'Descendation':
        require_once("Vues/HeuresDescendues.php");
  break;

    case 'Burndownchart':
        require_once("Vues/BurnDownChart.php");
  break;

      case 'GestionSprint':
        require_once("Vues/Gestion_Sprint.php");
  break;

case 'GestionDescendation':
        require_once("Vues/Gestion_HeuresDescendues.php");
  break;

case 'GestionEmploye':
        require_once("Vues/Gestion_Employe.php");
  break;

  case 'Parametres':
        require_once("Vues/Gestion_Parametres.php");
  break;

    case 'Objectifs':
        require_once("Vues/Objectifs.php");
  break;

    default:
        print('<body class="fixed-nav sticky-footer" id="page-top"><div class="content-wrapper">
      <div class="container">JE CONNAIS PAS CETTE PAGE, TU ME DEMANDE "'. $vue .'" MAIS C\'EST QUOI AU JUSTE :((');
  break;
}

require_once("Vues/footer.php");

?>

