<?php
    
    require_once('Configs.php');

//+-+-+-+-+-+-+-+-+-+-+ Infos Note +-+-+-+-+-+-+-+-+-+-+

  if ($_POST["action"] == "putNote") {
    $statement = $connection->prepare(
      "UPDATE projet 
      SET projet_note = :Note_Text
      WHERE projet_pk = :Projet_Id"
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

  //+-+-+-+-+-+-+-+-+-+-+ Infos Budget +-+-+-+-+-+-+-+-+-+-+

  if ($_POST["action"] == "getBudgets") {
    $statement = $connection->prepare(
      "SELECT * FROM projet_budget 
    WHERE projet_budget_fk_projet = '" . $_POST["projectId"] . "'"
    );
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    print json_encode($result);
  }

  if ($_POST["action"] == "Delete_Projet_Budget") {

    $statement = $connection->prepare(
      "DELETE FROM projet_budget
      WHERE projet_budget_pk = :projet_budget_pk"
    );
    $result = $statement->execute(
      array(
        ':projet_budget_pk' => $_POST["projet_budget_pk"]
      )
    );

    if ($statement->rowCount() > 0){
      print true;
    }
    else
        print_r($statement->errorInfo());
  }

  if ($_POST["action"] == "Update_Projet_Budget") {

    $statement = $connection->prepare(
      "UPDATE projet_budget 
      SET
      projet_budget_label = :projet_budget_label,
      projet_budget_montant = :projet_budget_montant,
      projet_budget_fk_projet = :projet_budget_fk_projet
      WHERE projet_budget_pk = :projet_budget_pk"
      );
      $result = $statement->execute(
      array(
        ':projet_budget_label' => $_POST["projet_budget_label"],
        ':projet_budget_montant' => $_POST["projet_budget_montant"],
        ':projet_budget_fk_projet' => $_POST["projet_budget_fk_projet"],
        ':projet_budget_pk' => $_POST["projet_budget_pk"]
      )
      );
      if (!empty($result))
        print true;
      else
        print_r($statement->errorInfo());
  }

  if ($_POST["action"] == "Create_Projet_Budget") {

    $statement = $connection->prepare(
    "INSERT INTO projet_budget (projet_budget_label, projet_budget_montant, projet_budget_fk_projet) 
    VALUES (:projet_budget_label, :projet_budget_montant, :projet_budget_fk_projet)
    ");
      $result = $statement->execute(
        array(
          ':projet_budget_label' => $_POST["projet_budget_label"],
          ':projet_budget_montant' => $_POST["projet_budget_montant"],
          ':projet_budget_fk_projet' => $_POST["projet_budget_fk_projet"]
        )
      );
    if (!empty($result))
      print true;
    else
      print_r($statement->errorInfo());
  }
     

//+-+-+-+-+-+-+-+-+-+-+ Pas encore rangé +-+-+-+-+-+-+-+-+-+-+

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "getClient") {
        $output = array();
        $statement = $connection->prepare(
        "SELECT *
        FROM projet_client 
         WHERE projet_client_pk = (select projet_fk_client from projet where projet_pk = '" . $_POST["projectId"] . "') 
         LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetch();

        print json_encode($result);
      }

      if ($_POST["action"] == "putClient") {

        $statement = $connection->prepare(
          "UPDATE projet_client 
          SET projet_client_entreprise = :clientprojet_entreprise, projet_client_nom = :clientprojet_nom, projet_client_job = :clientprojet_job, projet_client_mail = :clientprojet_mail, projet_client_telephone = :clientprojet_telephone
          WHERE projet_client_pk = :clientprojet_id"
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
          "SELECT *
            FROM user
            inner join projet_ressource on projet_ressource_fk_user = user_pk
           WHERE user_pk in (select projet_ressource_fk_user from projet_ressource where projet_ressource_fk_projet = " . $_POST["projectId"] . ")
           ORDER BY user_prenom"
        );
        $statement->execute();
        $result = $statement->fetchAll();

        $resultat = [];

        foreach ($result as $row) {

          $MonTest = [];

          if (file_exists("../Assets/Image/Ressources/avatar_user_" . $row["user_pk"] .".png")) {
            $MonTest['Avatar'] = "avatar_user_" . $row["user_pk"] .".png";
          }else{
            $MonTest['Avatar'] = "default.png";
          }

          $MonTest['RessourceId'] = 'ressource_'.$row['projet_ressource_pk'];
          $MonTest['Prenom'] = $row['user_prenom'];
          $MonTest['Job'] = $row['user_type'];

          $resultat[] = $MonTest;
        }

        print json_encode($resultat);
      }
      
      if ($_POST["action"] == "AddRessource") {

        $TableauEmploye = $_POST["UserId"];

        $statement = $connection->prepare(
        "INSERT INTO projet_ressource (projet_ressource_fk_projet, projet_ressource_fk_user) 
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
        WHERE projet_ressource_pk = :id_ressource"
      );
      $result = $statement->execute(
        array(
          ':id_ressource' => $_POST["idRessource"]
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
          "SELECT projet_technologie_technologie, projet_technologie_pk
          FROM projet_technologie
           WHERE projet_technologie_fk_projet = " . $_POST["projectId"]
        );
        $statement->execute();
        $result = $statement->fetchAll();

        $resultat = [];

        foreach ($result as $row) {

          $MonTest = [];

          $MonTest['technologieId'] = 'technologie_'.$row['projet_technologie_pk'];
          $MonTest['technologie'] = $row['projet_technologie_technologie'];

          $resultat[] = $MonTest;
        }

        print json_encode($resultat);
      }

      if ($_POST["action"] == "AddTechno") {
          $statement = $connection->prepare(
          "INSERT INTO projet_technologie (projet_technologie_technologie, projet_technologie_fk_projet) 
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
          WHERE projet_technologie_pk = :id_technologie"
        );
        $result = $statement->execute(
          array(
            ':id_technologie' => $_POST["idTechno"]
          )
        );
        if ($statement->rowCount() > 0)
          print true;
        else
        print_r($statement->errorInfo());
    }

    if ($_POST["action"] == "getEchanges") {
      $output = array();
      $statement = $connection->prepare(
        "SELECT *
        FROM projet_echange
         WHERE projet_echange_fk_projet = " . $_POST["projectId"]."
         ORDER BY projet_echange_date asc"
      );
      $statement->execute();
      $result = $statement->fetchAll();

      $resultat = [];

      foreach ($result as $row) {

        $MonTest = [];

        $MonTest['id_echange'] = $row['projet_echange_pk'];
        $MonTest['resume_echange'] = $row['projet_echange_label'];
        $MonTest['date_echange'] = date("d/m/Y", strtotime($row['projet_echange_date']));;
        $MonTest['type_echange'] = $row['projet_echange_type'];

        $resultat[] = $MonTest;
      }

      print json_encode($resultat);
    }

    if ($_POST["action"] == "getEchange") {

      $statement = $connection->prepare(
        "SELECT *
         FROM projet_echange
         WHERE projet_echange_pk = " . $_POST["idComment"]
      );
      $statement->execute();
      $result = $statement->fetch();

      $resultat = [];

      $resultat['id_echange'] = $result['projet_echange_pk'];
      $resultat['resume_echange'] = $result['projet_echange_label'];
      $resultat['date_echange'] = date("d-m-Y", strtotime($result['projet_echange_date']));
      $resultat['type_echange'] = $result['projet_echange_type'];

      print json_encode($resultat);
    }

    if ($_POST["action"] == "postEchange") {
      $statement = $connection->prepare(
      "INSERT INTO projet_echange (projet_echange_label, projet_echange_date, projet_echange_type, projet_echange_fk_projet) 
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
      SET projet_echange_label = :resume_echange, projet_echange_date = :date_echange, projet_echange_type = :type_echange
      WHERE projet_echange_pk = :resume_id"
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
        WHERE projet_echange_pk = :id_echange"
      );
      $result = $statement->execute(
        array(
          ':id_echange' => $_POST["idEchange"]
        )
      );
      if ($statement->rowCount() > 0)
        print true;
      else
        print_r($statement->errorInfo());
  }

}

    ?> 