   <?php

  require_once('../Modele/Configs.php');

  if (isset($_POST["action"])) {

    if ($_POST["action"] == "GetTotalHeuresDescenduesParEmploye") {

      $NumeroduSprint = $_POST["NumeroduSprint"];

      //Requete pour obtenir la liste des heures attribués / descendues / interferances par ressource (soit le graphe tout en bas)
      $statement = $connection->prepare(
        $sql = "SELECT 
        E.id as empid,
        E.prenom as prenom,
        E.Initial as Initial,
        sum(A.heure) as nbheureadescendre,
        ( SELECT ifnull( sum(attribution.heure),0) from attribution where attribution.id_Employe = E.id and attribution.id_Sprint = $NumeroduSprint and attribution.Done is not null) as nbheuredescendu,
        ( SELECT ifnull( sum(attribution.heure),0) from attribution where attribution.id_Employe = E.id and attribution.id_Sprint = $NumeroduSprint and attribution.Done is null) as heurerestantes,
        (select ifnull(SUM(interference.heure),0) from interference where interference.id_Employe = E.id and interference.id_Sprint = $NumeroduSprint) as heuresinterference
        from employe as E
        LEFT JOIN attribution as A ON A.id_employe = E.id and A.id_Sprint = $NumeroduSprint
        WHERE
        A.heure is not null
        GROUP BY E.id
        order by nbheuredescendu desc, heurerestantes asc
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
        sum(A.heure) as nbheureadescendre,
        ( SELECT ifnull( sum(attribution.heure),0) from attribution where attribution.id_Projet = P.id and attribution.id_Sprint = $NumeroduSprint and attribution.Done is not null) as nbheuredescendu,
        ( SELECT ifnull( sum(attribution.heure),0) from attribution where attribution.id_Projet = P.id and attribution.id_Sprint = $NumeroduSprint and attribution.Done is null) as heurerestantes,
        (select ifnull(SUM(interference.heure),0) from interference where interference.id_Projet = P.id and interference.id_Sprint = $NumeroduSprint) as heuresinterference
        from projet as P
        LEFT JOIN attribution AS A ON A.id_Projet = P.id and A.id_Sprint = $NumeroduSprint
        WHERE
        A.heure is not null
        AND A.id_TypeTache IS NULL
        GROUP BY P.id
        order by nbheuredescendu desc, heurerestantes desc
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
        $sql = "SELECT COUNT(objectif.id) as Nombre, statutobjectif.nom as Statut, statutobjectif.couleur as Couleur
      from objectif
      join statutobjectif on statutobjectif.id = objectif.id_StatutObjectif
      WHERE objectif.id_Sprint = $NumeroduSprint
      GROUP BY objectif.id_StatutObjectif
      ORDER BY objectif.id_StatutObjectif
      "
      );

      $statement->execute();
      $result = $statement->fetchAll();

      $Total = [];

      foreach ($result as $row) {

        $MonTest = [];

        $MonTest[] = $row['Statut'];
        $MonTest[] = intval($row['Nombre']);
        $MonTest[] = $row['Couleur'];

        $Total[] = $MonTest;

      }

      $array['Objectifs'] = $Total;

      //Requete pour obtenir la  charte "Total heures attribuées/descendues (toutes ressources comprises)" 
      $statement = $connection->prepare(
        $sql = "SELECT
        (select sum(heure) from attribution A WHERE A.id_Sprint = $NumeroduSprint) as TotalHeuresAttribuees,
        (select sum(heure) from attribution A WHERE A.id_Sprint = $NumeroduSprint AND A.Done is not NULL) as TotalHeuresDescendues,
        (select sum(heure) from interference I WHERE I.id_Sprint = $NumeroduSprint) as TotalHeuresInterference"
      );

      $statement->execute();
      $result = $statement->fetchAll();

      foreach ($result as $row) {
        $TotalHeuresAttribuees[] = intval($row['TotalHeuresAttribuees']);
        $TotalHeuresDescendues[] = intval($row['TotalHeuresDescendues']);
        $TotalHeuresInterference[] = intval($row['TotalHeuresInterference']);
      }

      $array['TotalHeuresAttribuees'] = $TotalHeuresAttribuees;
      $array['TotalHeuresDescendues'] = $TotalHeuresDescendues;
      $array['TotalHeuresInterference'] = $TotalHeuresInterference;

      //Combiens d'heures descendues par jour pour remplir la charte "Heures descendues par jour (toutes ressources comprises)"
      $statement = $connection->prepare(
        $sql = "SELECT
        sum(heure) as heures, Done
        FROM attribution A
        where A.id_Sprint = $NumeroduSprint
        AND A.Done is not null
        GROUP by Done
        ORDER by Done"
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
        $sql = "SELECT * from sprint S where S.id = $NumeroduSprint"
      );
      $statement->execute();
      $result = $statement->fetch();
      $array['DateFinSprint'] = $result["dateFin"];
      $array['DateDebutSprint'] = $result["dateDebut"];

    }

    echo json_encode($array);

  }

  ?>
