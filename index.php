<?php
session_start();

require_once ('Modele/Configs.php');
include("Vues/header.php");


if(!isset($_REQUEST['vue']))
{
    $_REQUEST['vue'] = 'Acceuil';
}

$vue = $_REQUEST['vue'];

switch($vue)
{
    case 'Acceuil':
        include("Vues/Dashboard.php");
  break;

    case 'Sprint':
        include("Vues/CreerSprint.php");
  break;

    case 'Attribution':
        include("Vues/AttributionHeures.php");
  break;

  case 'Descendation':
        include("Vues/HeuresDescendues.php");
  break;

    case 'Burndownchart':
        include("Vues/BurnDownChart.php");
  break;

      case 'GestionSprint':
        include("Vues/Gestion_Sprint.php");
  break;

case 'GestionDescendation':
        include("Vues/Gestion_HeuresDescendues.php");
  break;

case 'GestionEmploye':
        include("Vues/Gestion_Employe.php");
  break;

  case 'Parametres':
        include("Vues/Gestion_Parametres.php");
  break;

    case 'Objectifs':
        include("Vues/Objectifs.php");
  break;

    default:
        print('<body class="fixed-nav sticky-footer" id="page-top"><div class="content-wrapper">
      <div class="container">JE CONNAIS PAS CETTE PAGE, TU ME DEMANDE "'. $vue .'" MAIS C\'EST QUOI AU JUSTE :((');
  break;
}

include("Vues/footer.php");

?>

