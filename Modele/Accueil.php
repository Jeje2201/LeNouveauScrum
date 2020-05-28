   <?php

    require_once('Configs.php');

    if (isset($_POST["action"])) {

      $NumeroduSprint = $_POST["NumeroduSprint"];

      if ($_POST["action"] == "GetTotalHeuresDescenduesParEmploye") {


        //Requete pour obtenir la liste des heures attribués / DESCendues / interferances par ressource (soit le graphe tout en bas)
        $statement = $connection->prepare(
          $sql = "SELECT 
        user_pk,
        user_prenom,
        user_initial,
        sum(tache_heure) AS nbheureadescendre,
        (
          SELECT IFNULL( sum(tache_heure),0)
          FROM tache
          WHERE tache_fk_user = user_pk
          AND tache_fk_sprint = $NumeroduSprint 
          AND tache_done IS NOT NULL
        ) AS nbheuredescendu,
        (
          SELECT IFNULL( sum(tache_heure),0)
          FROM tache
          WHERE tache_fk_user = user_pk
          AND tache_fk_sprint = $NumeroduSprint
          AND tache_done
           IS NULL
          ) AS heurerestantes,
        (
          select IFNULL(SUM(interference_heure),0)
          FROM interference
          WHERE interference_fk_user = user_pk
          AND interference_fk_sprint = $NumeroduSprint
        ) AS heuresinterference
        FROM user
        LEFT JOIN tache ON tache_fk_user = user_pk
        AND tache_fk_sprint = $NumeroduSprint
        WHERE
        tache_heure IS NOT NULL
        GROUP BY user_pk
        ORDER BY nbheuredescendu DESC, heurerestantes asc
      "
        );

        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {

          $employe[] = $row['user_prenom'] . ' (' . $row['user_initial'] . ')';
          $HDescendue[] = intval($row['nbheuredescendu']);
          $Hattribue[] = intval($row['nbheureadescendre']);
          $HInterference[] = intval($row['heuresinterference']);
        }

        $array['NomRessource'] = $employe;
        $array['RessourceHeuresDescendues'] = $HDescendue;
        $array['RessourceHeureAttribuees'] = $Hattribue;
        $array['RessourceHeureInterference'] = $HInterference;

        //Une chart, laquelle ?

        $statement = $connection->prepare(
          $sql = "SELECT 
        projet_nom,
        sum(tache_heure) AS nbheureadescendre,
        (
          SELECT IFNULL( sum(tache_heure),0)
          FROM tache
          WHERE tache_fk_projet = projet_pk
          AND tache_fk_sprint = $NumeroduSprint
          AND tache_done IS NOT NULL) AS nbheuredescendu,
        (
          SELECT IFNULL( sum(tache_heure),0)
          FROM tache
          WHERE tache_fk_projet = projet_pk
          AND tache_fk_sprint = $NumeroduSprint
          AND tache_done  IS NULL
        ) AS heurerestantes,
        (
          SELECT IFNULL(SUM(interference_heure),0)
          FROM interference
          WHERE interference_fk_projet = projet_pk
          AND interference_fk_sprint = $NumeroduSprint
          ) AS heuresinterference
        FROM projet
        LEFT JOIN tache ON tache_fk_projet = projet_pk AND tache_fk_Sprint = $NumeroduSprint
        WHERE
        tache_heure IS NOT NULL
        AND tache_type IS NULL
        GROUP BY projet_pk
        ORDER BY nbheuredescendu DESC, heurerestantes DESC
       ");

        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {

          $projet[] = $row['projet_nom'];
          $HDescendueProjet[] = intval($row['nbheuredescendu']);
          $HattribueProjet[] = intval($row['nbheureadescendre']);
          $HInterferenceProjet[] = intval($row['heuresinterference']);
        }

        $array['NomProjet'] = $projet;
        $array['ProjetHeuresDescendues'] = $HDescendueProjet;
        $array['ProjetHeuresAttribuees'] = $HattribueProjet;
        $array['ProjetHeuresInterferences'] = $HInterferenceProjet;

        //Requete pour obtenir la  charte "Total heures attribuées/descendues (toutes ressources comprises)" 
        $statement = $connection->prepare(
          $sql = "SELECT
        (select sum(tache_heure) FROM tache WHERE tache_fk_sprint = $NumeroduSprint) AS TotalHeuresAttribuees,
        (select sum(tache_heure) FROM tache WHERE tache_fk_sprint = $NumeroduSprint AND tache_done IS NOT NULL) AS TotalHeuresDescendues,
        (select sum(interference_heure) FROM interference WHERE interference_fk_sprint = $NumeroduSprint) AS TotalHeuresInterference"
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
        sum(tache_heure) AS heures, tache_done
        FROM tache
        WHERE tache_fk_sprint = $NumeroduSprint
        AND tache_done IS NOT NULL
        GROUP by tache_done
        ORDER BY tache_done"
        );

        $statement->execute();
        $result = $statement->fetchAll();

        $BurndownchartHeures = $array['TotalHeuresAttribuees'][0];

        foreach ($result as $row) {
          $BurndownchartHeures -= intval($row['heures']);
          $BurndownchartHeuresTable[] = $BurndownchartHeures;
          $Descendues[] = intval($row['heures']);
          $Date[] = date("d-m-Y", strtotime($row['tache_done']));
        }

        $array['HeuresDescenduesParJour'] = $Descendues;
        $array['DateHeuresDescenduesParJour'] = $Date;
        $array['BurndownchartHeuresTable'] = $BurndownchartHeuresTable;

        $statement = $connection->prepare(
          $sql = "SELECT *
        FROM sprint
        WHERE sprint_pk = $NumeroduSprint"
        );
        $statement->execute();
        $result = $statement->fetch();
        $array['DateFinSprint'] = $result["sprint_dateFin"];
        $array['DateDebutSprint'] = $result["sprint_dateDebut"];

        print json_encode($array);
      }

      if ($_POST["action"] == "ObjectifStat") {
        $statement = $connection->prepare("SELECT COUNT(retrospective_objectif_pk) AS Nombre,
                  retrospective_objectif_statut AS Statut
                FROM retrospective_objectif O
                WHERE retrospective_objectif_fk_sprint = $NumeroduSprint
                GROUP BY retrospective_objectif_statut
                ORDER BY retrospective_objectif_statut");

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        print json_encode($result);
    }

    if ($_POST["action"] == "Last10Sprint") {

      $statement = $connection->prepare("SELECT sprint_numero FROM sprint ORDER BY sprint.sprint_pk DESC limit 10");
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);

      foreach ($result as $row) {
        $ListSprint[] = $row['sprint_numero'];
      }

      $return['Sprint_Numero'] = array_reverse($ListSprint);

      for ($i=0 ; $i<10 ; $i++)
      {
        $statement = $connection->prepare("SELECT
        (select sum(tache_heure) FROM tache WHERE tache_fk_sprint = (SELECT sprint_pk FROM `sprint` ORDER BY `sprint`.`sprint_pk` DESC limit 1 OFFSET $i)) AS TotalHeuresAttribuees,
        (select sum(tache_heure) FROM tache WHERE tache_fk_sprint = (SELECT sprint_pk FROM `sprint` ORDER BY `sprint`.`sprint_pk` DESC limit 1 OFFSET $i) AND tache_done IS NOT NULL) AS TotalHeuresDescendues");

        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        $Last10[] = round($result["TotalHeuresDescendues"] / $result["TotalHeuresAttribuees"] * 100);
      }

      $return['Taux_Completion'] = array_reverse($Last10);

      print json_encode($return);
      
    }
      
    }

    ?> 