   <?php

  require_once('../Modele/Configs.php');

  if (isset($_POST["action"])) {


    if ($_POST["action"] == "GetLesInfosDeLaBurnDownChart") {

      $NumeroSprint = $_POST["NumeroSprint"];

      //requete sql périmé si 0 sprint
      $statement = $connection->prepare(
        $sql = "SELECT $NumeroSprint as sprint, burndownhour as Heures, date as Jours, (SELECT sum(interference.heure)
        FROM interference
        where interference.id_Sprint = ( SELECT sprint.id FROM sprint WHERE sprint.numero = $NumeroSprint )) as interferances
        FROM `vburndown` where id_Sprint = (SELECT sprint.id FROM sprint WHERE sprint.numero = $NumeroSprint)order by Date"
      );
      $statement->execute();
      $result = $statement->fetchAll();

      $Jours = [];
      $Heures = [];
      $interferences = [];

      foreach ($result as $row) {
        $Heures[] = intval($row['Heures']);

        $interferences = intval($row['interferances']);

        $Jours[] = date("d-m-Y", strtotime($row['Jours']));
      }

      $array['JoursAvecDesHeures'] = $Jours;

      $array['HeuresDesJours'] = $Heures;

      $array['Interference'] = $interferences;

      $array['NumeroSprint'] = intval($NumeroSprint);

      //Total d'heures a descendres (pour les infos a droite de la bdc)
      $statement = $connection->prepare(
        "SELECT sum(A.heure) as Total from attribution A where A.id_Sprint = (Select S.id from sprint S where S.numero = $NumeroSprint)"
      );
      $statement->execute();
      $result = $statement->fetch();
      $ToutADescendre = [];
      $ToutADescendre = intval($result["Total"]);

      $array['TotalADescendre'] = $ToutADescendre;

      //Obtenir date de début et de fin
      $statement = $connection->prepare($sql = "SELECT dateDebut, dateFin from sprint S where S.numero = $NumeroSprint");
      $statement->execute();
      $result = $statement->fetch();

      $array['DateDebut'] = $result["dateDebut"];
      $array['DateFin'] = $result["dateFin"];


    }

    echo json_encode($array);

  }

  ?>
