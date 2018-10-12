   <?php

  require_once('../Modele/Configs.php');

  if (isset($_POST["action"])) {

    if ($_POST["action"] == "GetTotalADescendre") {

      $NumeroSprint = $_POST["NumeroSprint"];
      $statement = $connection->prepare(
        "SELECT sum(attribution.heure) as Total from attribution where attribution.id_Sprint = (Select sprint.id from sprint where sprint.numero = $NumeroSprint) AND attribution.id_TypeTache IS NULL"
      );
      $statement->execute();
      $result = $statement->fetch();
      echo $result["Total"];
    }

    if ($_POST["action"] == "GetLesInfosDeLaBurnDownChart") {

      $NumeroSprint = $_POST["NumeroSprint"];

      //requete sql périmé si 0 sprint
      $statement = $connection->prepare(
        $sql = "SELECT $NumeroSprint as sprint, burndownhour as Heures, date as Jours, (SELECT sum(interference.heure)  FROM interference where interference.id_Sprint = ( SELECT sprint.id FROM sprint WHERE sprint.numero = $NumeroSprint )) as interferances FROM `vburndown`where id_Sprint = (SELECT sprint.id FROM sprint WHERE sprint.numero = $NumeroSprint) order by Date"
      );
      $statement->execute();
      $result = $statement->fetchAll();

      foreach ($result as $row) {
        $Heures[] = intval($row['Heures']);

        $interferences = intval($row['interferances']);

        $Jours[] = date("d-m-Y", strtotime($row['Jours']));
      }

      $array['JoursAvecDesHeures'] = $Jours;

      $array['HeuresDesJours'] = $Heures;

      $array['Interference'] = $interferences;

      $array['NumeroSprint'] = intval($NumeroSprint);

      $statement = $connection->prepare(
        "SELECT sum(attribution.heure) as Total from attribution where attribution.id_Sprint = (Select sprint.id from sprint where sprint.numero = $NumeroSprint) AND attribution.id_TypeTache IS NULL"
      );
      $statement->execute();
      $result = $statement->fetch();
      $ToutADescendre = intval($result["Total"]);

      $array['TotalADescendre'] = $ToutADescendre;

      $statement = $connection->prepare($sql = "SELECT dateDebut, dateFin from sprint where sprint.numero = $NumeroSprint");
      $statement->execute();
      $result = $statement->fetch();

      $array['DateDebut'] = $result["dateDebut"];
      $array['DateFin'] = $result["dateFin"];


    }

    echo json_encode($array);

  }

  ?>
