   <?php

    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "GetTotalHeuresDescenduesParEmploye") {

        $NumeroduSprint = $_POST["NumeroduSprint"];

        //Requete pour obtenir la liste des heures attribués / DESCendues / interferances par ressource (soit le graphe tout en bas)
        $statement = $connection->prepare(
          $sql = "SELECT 
        E.id AS empid,
        E.prenom AS prenom,
        E.Initial AS Initial,
        sum(A.heure) AS nbheureadescendre,
        (
          SELECT IFNULL( sum(A.heure),0)
          FROM tache A
          WHERE A.id_Employe = E.id
          AND A.id_Sprint = $NumeroduSprint 
          AND A.Done IS NOT NULL
        ) AS nbheuredescendu,
        (
          SELECT IFNULL( sum(A.heure),0)
          FROM tache A
          WHERE A.id_Employe = E.id
          AND A.id_Sprint = $NumeroduSprint
          AND A.Done
           IS NULL
          ) AS heurerestantes,
        (
          select IFNULL(SUM(I.heure),0)
          FROM interference I
          WHERE I.id_Employe = E.id
          AND I.id_Sprint = $NumeroduSprint
        ) AS heuresinterference
        FROM employe E
        LEFT JOIN tache A ON A.id_employe = E.id
        AND A.id_Sprint = $NumeroduSprint
        WHERE
        A.heure IS NOT NULL
        GROUP BY E.id
        ORDER BY nbheuredescendu DESC, heurerestantes asc
      "
        );

        $statement->execute();
        $result = $statement->fetchAll();

        $employe = [];
        $HDescendue = [];
        $Hattribue = [];
        $HInterference = [];

        foreach ($result as $row) {

          $employe[] = $row['prenom'] . ' (' . $row['Initial'] . ')';
          $HDescendue[] = intval($row['nbheuredescendu']);
          $Hattribue[] = intval($row['nbheureadescendre']);
          $HInterference[] = intval($row['heuresinterference']);
        }

        $array['NomRessource'] = $employe;
        $array['RessourceHeuresDescendues'] = $HDescendue;
        $array['RessourceHeureAttribuees'] = $Hattribue;
        $array['RessourceHeureInterference'] = $HInterference;

        $statement = $connection->prepare(
          $sql = "SELECT 
        P.id AS projid,
        P.nom AS pnom,
        sum(A.heure) AS nbheureadescendre,
        (
          SELECT IFNULL( sum(A.heure),0)
          FROM tache A
          WHERE A.id_Projet = P.id
          AND A.id_Sprint = $NumeroduSprint
          AND A.Done IS NOT NULL) AS nbheuredescendu,
        (
          SELECT IFNULL( sum(A.heure),0)
          FROM tache A
          WHERE A.id_Projet = P.id
          AND A.id_Sprint = $NumeroduSprint
          AND A.Done  IS NULL
        ) AS heurerestantes,
        (
          SELECT IFNULL(SUM(I.heure),0)
          FROM interference I
          WHERE I.id_Projet = P.id
          AND I.id_Sprint = $NumeroduSprint
          ) AS heuresinterference
        FROM projet AS P
        LEFT JOIN tache AS A ON A.id_Projet = P.id AND A.id_Sprint = $NumeroduSprint
        WHERE
        A.heure IS NOT NULL
        AND A.tache_type IS NULL
        GROUP BY P.id
        ORDER BY nbheuredescendu DESC, heurerestantes DESC
       "
        );

        $statement->execute();
        $result = $statement->fetchAll();

        $projet = [];
        $HDescendueProjet = [];
        $HattribueProjet = [];
        $HInterferenceProjet = [];

        foreach ($result as $row) {

          $projet[] = $row['pnom'];
          $HDescendueProjet[] = intval($row['nbheuredescendu']);
          $HattribueProjet[] = intval($row['nbheureadescendre']);
          $HInterferenceProjet[] = intval($row['heuresinterference']);
        }

        $array['NomProjet'] = $projet;
        $array['ProjetHeuresDescendues'] = $HDescendueProjet;
        $array['ProjetHeuresAttribuees'] = $HattribueProjet;
        $array['ProjetHeuresInterferences'] = $HInterferenceProjet;

        //Requete pour la charte des objectifs
        $statement = $connection->prepare(
          $sql = "SELECT COUNT(O.id) AS Nombre,
        O.objectif_statut AS Statut
      FROM retrospective_objectif O
      WHERE O.id_Sprint = $NumeroduSprint
      GROUP BY O.objectif_statut
      ORDER BY O.objectif_statut
      "
        );

        $statement->execute();
        $result = $statement->fetchAll();

        $Total = [];

        foreach ($result as $row) {

          $MonTest = [];

          $MonTest[] = $row['Statut'];
          $MonTest[] = intval($row['Nombre']);

          switch ($row['Statut']) {
            case "En cours":
              $MonTest[] = '#E88648';
              break;
            case "Ok":
              $MonTest[] = '#95D972';
              break;
            case "Annule":
              $MonTest[] = '#424242';
              break;
            case "Non":
              $MonTest[] = '#E8514E';
              break;
            case "Inconnue":
              $MonTest[] = '#007bff';
              break;
            default:
              $MonTest[] = '#c1349c';
        }
          $Total[] = $MonTest;
        }

        $array['Objectifs'] = $Total;

        //Requete pour obtenir la  charte "Total heures attribuées/descendues (toutes ressources comprises)" 
        $statement = $connection->prepare(
          $sql = "SELECT
        (select sum(heure) FROM tache A WHERE A.id_Sprint = $NumeroduSprint) AS TotalHeuresAttribuees,
        (select sum(heure) FROM tache A WHERE A.id_Sprint = $NumeroduSprint AND A.Done IS NOT NULL) AS TotalHeuresDescendues,
        (select sum(heure) FROM interference I WHERE I.id_Sprint = $NumeroduSprint) AS TotalHeuresInterference"
        );

        $statement->execute();
        $result = $statement->fetch();

        $TotalHeuresAttribuees[] = intval($result['TotalHeuresAttribuees']);
        $TotalHeuresDescendues[] = intval($result['TotalHeuresDescendues']);
        $TotalHeuresInterference[] = intval($result['TotalHeuresInterference']);

        $array['TotalHeuresAttribuees'] = $TotalHeuresAttribuees;
        $array['TotalHeuresDescendues'] = $TotalHeuresDescendues;
        $array['TotalHeuresInterference'] = $TotalHeuresInterference;

        //Combiens d'heures DESCendues par jour pour remplir la charte "Heures DESCendues par jour (toutes ressources comprises)"
        $statement = $connection->prepare(
          $sql = "SELECT
        sum(heure) AS heures, Done
        FROM tache A
        WHERE A.id_Sprint = $NumeroduSprint
        AND A.Done IS NOT NULL
        GROUP by Done
        ORDER BY Done"
        );

        $statement->execute();
        $result = $statement->fetchAll();

        $Descendues = [];
        $Date = [];
        $BurndownchartHeures = $array['TotalHeuresAttribuees'][0];
        $BurndownchartHeuresTable = [];

        foreach ($result as $row) {
          $BurndownchartHeures -= intval($row['heures']);
          $BurndownchartHeuresTable[] = $BurndownchartHeures;
          $Descendues[] = intval($row['heures']);
          $Date[] = date("d-m-Y", strtotime($row['Done']));
        }

        $array['HeuresDescenduesParJour'] = $Descendues;
        $array['DateHeuresDescenduesParJour'] = $Date;
        $array['BurndownchartHeuresTable'] = $BurndownchartHeuresTable;

        $statement = $connection->prepare(
          $sql = "SELECT *
        FROM sprint S
        WHERE S.id = $NumeroduSprint"
        );
        $statement->execute();
        $result = $statement->fetch();
        $array['DateFinSprint'] = $result["dateFin"];
        $array['DateDebutSprint'] = $result["dateDebut"];
      }

      print json_encode($array);
    }

    ?> 