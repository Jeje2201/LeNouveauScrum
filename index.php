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

}

include("Vues/footer.php");

?>

