   <?php

  require_once('../Modele/Configs.php');

  if (isset($_POST["action"])) {

    if ($_POST["action"] == "GetTotalHeuresDescenduesParEmploye") {

      $NumeroduSprint = $_POST["NumeroduSprint"];

      $statement = $connection->prepare(
        $sql = "
        SELECT 
        E.id as empid,
        E.prenom as prenom,
        E.Initial as Initial,
        sum(A.heure) as nbheureadescendre,
        ifnull( sum(HD.heure),0) as nbheuredescendu,
        sum(A.heure) - ifnull( sum(HD.heure),0) as heurerestantes,
        (select ifnull(SUM(interference.heure),0) from interference where interference.id_Employe = E.id and interference.id_Sprint = $NumeroduSprint) as heuresinterference
        from Employe as E
        LEFT JOIN attribution as a ON a.id_employe = e.id and a.id_Sprint = $NumeroduSprint
        LEFT JOIN heuresdescendues as hd on e.id = hd.id_Employe and hd.id_Attribution = a.id and hd.id_Sprint = $NumeroduSprint
        WHERE
        A.heure is not null
        AND A.id_TypeTache IS NULL
        GROUP BY E.id
        order by nbheuredescendu desc, heurerestantes asc
      "
      );

      $statement->execute();
      $result = $statement->fetchAll();

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
        $sql = "
        SELECT 
        P.id as projid,
        P.nom as pnom,
        sum(A.heure) as nbheureadescendre,
        ifnull( sum(HD.heure),0) as nbheuredescendu,
        sum(A.heure) - ifnull( sum(HD.heure),0) as heurerestantes,
        (select ifnull(SUM(interference.heure),0) from interference where interference.id_Projet = P.id and interference.id_Sprint = $NumeroduSprint) as heuresinterference
        from projet as P
        LEFT JOIN attribution as a ON a.id_Projet = p.id and a.id_Sprint = $NumeroduSprint
        LEFT JOIN heuresdescendues as hd on hd.id_Projet = p.id and hd.id_Attribution = a.id and hd.id_Sprint = $NumeroduSprint
        WHERE
        A.heure is not null
        AND A.id_TypeTache IS NULL
        GROUP BY P.id
        order by nbheuredescendu desc, heurerestantes desc
       "
      );

      $statement->execute();
      $result = $statement->fetchAll();

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


      $statement = $connection->prepare(
        $sql = "SELECT (select sum(heure) from attribution WHERE attribution.id_Sprint = $NumeroduSprint and attribution.id_TypeTache IS NULL) as TotalHeuresAttribuees, (select sum(heure) from heuresdescendues WHERE heuresdescendues.id_Sprint = $NumeroduSprint) as TotalHeuresDescendues, (select sum(heure) from interference WHERE interference.id_Sprint = $NumeroduSprint) as TotalHeuresInterference"
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

      $statement = $connection->prepare(
        $sql = "SELECT sum(heure) as heures, DateDescendu as Ladate FROM `heuresdescendues` where heuresdescendues.id_Sprint = $NumeroduSprint GROUP by DateDescendu"
      );

      $statement->execute();
      $result = $statement->fetchAll();

      foreach ($result as $row) {
        $Descendues[] = intval($row['heures']);
        $Date[] = date("d-m-Y", strtotime($row['Ladate']));

      }
      if(empty($Descendues))
      $Descendues[] = 0;
      if(empty($Date))
      $Date[] = 0;
      $array['HeuresDescenduesParJour'] = $Descendues;
      $array['DateHeuresDescenduesParJour'] = $Date;

      $statement = $connection->prepare(
        $sql = "SELECT * from sprint where sprint.id = $NumeroduSprint"
      );
      $statement->execute();
      $result = $statement->fetch();
      $array['DateFinSprint'] = $result["dateFin"];
      $array['DateDebutSprint'] = $result["dateDebut"];

    }

    echo json_encode($array);

  }

  ?>
