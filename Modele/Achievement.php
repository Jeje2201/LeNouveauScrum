   <?php

    session_start();
    require_once('Configs.php');

    if (isset($_POST["action"])) {

      //Load les fiches de temps de tout le monde dans la gestion des fiches de temps
      if ($_POST["action"] == "Trophee") {

        $output = array();
        $statement = $connection->prepare(
          "SELECT sum(fiche_de_temps_time)/60/7.4 from fiche_de_temps
          where fiche_de_temps_fk_user = 22
          and fiche_de_temps_fk_projet = (SELECT projet_pk from projet where projet_nom like 'Congés')"
        );
        $statement->execute();
        $output['TotJourDeConge'] =  $statement->fetch(PDO::FETCH_COLUMN);

        print json_encode($output);
      }

    }
    ?> 