<?php
    
require_once('../Modele/Configs.php');

//+-+-+-+-+-+-+-+-+-+-+ Infos Note +-+-+-+-+-+-+-+-+-+-+

  if ($_POST["action"] == "getNote") {
    $output = array();
    $statement = $connection->prepare(
      "SELECT Note FROM projet 
    WHERE id = '" . $_POST["projectId"] . "'"
    );
    $statement->execute();
    $result = $statement->fetch();

    $output["Note"] = $result["Note"];

    print json_encode($output);

  }

  if ($_POST["action"] == "putNote") {
    $statement = $connection->prepare(
      "UPDATE projet 
      SET Note = :Note_Text
      WHERE id = :Projet_Id"
      );
      $result = $statement->execute(
      array(
        ':Note_Text' => $_POST["Note_Text"],
        ':Projet_Id' => $_POST["projectId"]
      )
      );
      if (!empty($result))
        print true;
      else
        print_r($statement->errorInfo());
  }

//+-+-+-+-+-+-+-+-+-+-+ Pas encore rangé +-+-+-+-+-+-+-+-+-+-+

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "getDescription") {
        $output = array();
        $statement = $connection->prepare(
        "SELECT * FROM projet 
         WHERE id = '" . $_POST["projectId"] . "' 
         LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetch();

        $output["Nom"] = $result["nom"];
        $output["Description"] = $result["description"];
        $output["Logo"] = $result["Id_Logo"];

        print json_encode($output);
      }

      if ($_POST["action"] == "getClient") {
        $output = array();
        $statement = $connection->prepare(
        "SELECT * FROM clientprojet 
         WHERE id = (select id_client from projet where projet.id = '" . $_POST["projectId"] . "') 
         LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetch();

        $output["entreprise"] = $result["entreprise"];
        $output["Nom"] = $result["nom"];
        $output["job"] = $result["job"];
        $output["mail"] = $result["mail"];
        $output["telephone"] = $result["telephone"];
        $output["id"] = $result["id"];

        print json_encode($output);
      }

      if ($_POST["action"] == "putClient") {

        $statement = $connection->prepare(
          "UPDATE clientprojet 
          SET entreprise = :clientprojet_entreprise, nom = :clientprojet_nom, job = :clientprojet_job, mail = :clientprojet_mail, telephone = :clientprojet_telephone
          WHERE id = :clientprojet_id"
          );
          $result = $statement->execute(
          array(
            ':clientprojet_entreprise' => $_POST["client_entreprise"],
            ':clientprojet_nom' => $_POST["client_nom"],
            ':clientprojet_job' => $_POST["client_job"],
            ':clientprojet_mail' => $_POST["client_mail"],
            ':clientprojet_telephone' => $_POST["client_telephone"],
            ':clientprojet_id' => $_POST["client_id"]
          )
          );
          if (!empty($result))
            print true;
          else
            print_r($statement->errorInfo());
      }

      if ($_POST["action"] == "GetRessources") {
        $output = array();
        $statement = $connection->prepare(
          "SELECT E.prenom, E.avatar, E.id as ressourceID, T.nom as job FROM employe E
           INNER JOIN typeemploye T on E.id_TypeEmploye = T.id
           WHERE E.id in (select R.id_ressource from projet_ressource R where R.id_projet = " . $_POST["projectId"] . ")
           ORDER BY E.prenom"
        );
        $statement->execute();
        $result = $statement->fetchAll();

        $resultat = [];

        foreach ($result as $row) {

          $MonTest = [];

          $MonTest['RessourceId'] = 'ressource_'.$row['ressourceID'];
          $MonTest['Prenom'] = $row['prenom'];
          $MonTest['Avatar'] = $row['avatar'];
          $MonTest['Job'] = $row['job'];

          $resultat[] = $MonTest;
        }

        print json_encode($resultat);
      }
      
      if ($_POST["action"] == "AddRessource") {

        $TableauEmploye = $_POST["UserId"];

        $statement = $connection->prepare(
        "INSERT INTO projet_ressource (id_projet, id_ressource) 
        VALUES (:id_projet, :id_ressource)
        ");
        for ($i = 0; $i < count($TableauEmploye); $i++) {
          $result = $statement->execute(
            array(
              ':id_projet' => $_POST["projectId"],
              ':id_ressource' => intval($TableauEmploye[$i])
            )
          );
        }
        if (!empty($result))
          print true;
        else
          print_r($statement->errorInfo());
      }

    if ($_POST["action"] == "DellRessourceProjet") {

      $statement = $connection->prepare(
        "DELETE FROM projet_ressource
        WHERE id_ressource = :id_ressource
        AND id_projet = :id_projet"
      );
      $result = $statement->execute(
        array(
          ':id_ressource' => $_POST["idRessource"],
          ':id_projet' => $_POST["projectId"]
        )
      );

      if ($statement->rowCount() > 0){
        print true;
      }
      else
        print_r($statement->errorInfo());
  }

      if ($_POST["action"] == "GetTechnos") {
        $output = array();
        $statement = $connection->prepare(
          "SELECT T.technologie, T.id as technologieId FROM projet_technologie T
           WHERE T.id_projet = " . $_POST["projectId"]
        );
        $statement->execute();
        $result = $statement->fetchAll();

        $resultat = [];

        foreach ($result as $row) {

          $MonTest = [];

          $MonTest['technologieId'] = 'technologie_'.$row['technologieId'];
          $MonTest['technologie'] = $row['technologie'];

          $resultat[] = $MonTest;
        }

        print json_encode($resultat);
      }

      if ($_POST["action"] == "AddTechno") {
          $statement = $connection->prepare(
          "INSERT INTO projet_technologie (technologie, id_projet) 
          VALUES (:technologie, :id_projet)
          ");
          $result = $statement->execute(
            array(
              ':technologie' => $_POST["NouvelleTechno"],
              ':id_projet' => $_POST["projectId"]
            )
          );
          if (!empty($result))
            print true;
          else
            print_r($statement->errorInfo());
      }

      if ($_POST["action"] == "DellTechno") {

        $statement = $connection->prepare(
          "DELETE FROM projet_technologie
          WHERE id = :id_technologie
          AND id_projet = :id_projet"
        );
        $result = $statement->execute(
          array(
            ':id_technologie' => $_POST["idTechno"],
            ':id_projet' => $_POST["projectId"]
          )
        );
        if ($statement->rowCount() > 0)
          print true;
        else
          print 'Techno "'.$_POST["NomTechno"].'" non trouvée';
    }

    if ($_POST["action"] == "getEchanges") {
      $output = array();
      $statement = $connection->prepare(
        "SELECT E.id as resume_id, E.resume_echange, E.date_echange, E.type_echange FROM projet_echange E
         WHERE E.id_project = " . $_POST["projectId"]."
         ORDER BY date_echange asc"
      );
      $statement->execute();
      $result = $statement->fetchAll();

      $resultat = [];

      foreach ($result as $row) {

        $MonTest = [];

        $MonTest['id_echange'] = $row['resume_id'];
        $MonTest['resume_echange'] = $row['resume_echange'];
        $MonTest['date_echange'] = date("d/m/Y", strtotime($row['date_echange']));;
        $MonTest['type_echange'] = $row['type_echange'];

        $resultat[] = $MonTest;
      }

      print json_encode($resultat);
    }

    if ($_POST["action"] == "getEchange") {

      $statement = $connection->prepare(
        "SELECT E.id as resume_id, E.resume_echange, E.date_echange, E.type_echange FROM projet_echange E
         WHERE E.id = " . $_POST["idComment"]
      );
      $statement->execute();
      $result = $statement->fetch();

      $resultat = [];

      $resultat['id_echange'] = $result['resume_id'];
      $resultat['resume_echange'] = $result['resume_echange'];
      $resultat['date_echange'] = date("d-m-Y", strtotime($result['date_echange']));
      $resultat['type_echange'] = $result['type_echange'];

      print json_encode($resultat);
    }

    if ($_POST["action"] == "postEchange") {
      $statement = $connection->prepare(
      "INSERT INTO projet_echange (resume_echange, date_echange, type_echange, id_project) 
      VALUES (:resume_echange, :date_echange, :type_echange, :id_project)
      ");
      $result = $statement->execute(
        array(
          ':resume_echange' => $_POST["echange_label"],
          ':date_echange' => $_POST["echange_date"],
          ':type_echange' => $_POST["echange_type"],
          ':id_project' => $_POST["projectId"]
        )
      );
      if (!empty($result))
        print true;
      else
        print_r($statement->errorInfo());
  }

  if ($_POST["action"] == "putEchange") {

    $statement = $connection->prepare(
      "UPDATE projet_echange 
      SET resume_echange = :resume_echange, date_echange = :date_echange, type_echange = :type_echange
      WHERE id = :resume_id"
      );
      $result = $statement->execute(
      array(
        ':resume_echange' => $_POST["echange_label"],
        ':date_echange' => date("Y-m-d", strtotime($_POST["echange_date"])),
        ':type_echange' => $_POST["echange_type"],
        ':resume_id' => $_POST["echange_id"]
      )
      );
      if (!empty($result))
        print true;
      else
        print_r($statement->errorInfo());
  }

    if ($_POST["action"] == "DellEchange") {

      $statement = $connection->prepare(
        "DELETE FROM projet_echange
        WHERE id = :id_echange
        AND id_project = :id_projet"
      );
      $result = $statement->execute(
        array(
          ':id_echange' => $_POST["idEchange"],
          ':id_projet' => $_POST["projectId"]
        )
      );
      if ($statement->rowCount() > 0)
        print true;
      else
        print_r($statement->errorInfo());
  }

}

    ?> 