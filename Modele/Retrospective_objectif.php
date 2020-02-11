   <?php
    session_start();
    require_once('Configs.php');

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "getObjectifs") {
        $statement = $connection->prepare("SELECT * 
        FROM retrospective_objectif
        INNER JOIN projet ON projet_pk = retrospective_objectif_fk_projet
        INNER JOIN user ON user_pk = retrospective_objectif_fk_user
        WHERE retrospective_objectif_fk_sprint = '".$_POST["idAffiche"]."'
        ORDER BY user_prenom, projet_nom, retrospective_objectif_pk");
          $statement->execute();
          $result = $statement->fetchAll();

        print json_encode($result);
      }

      if ($_POST["action"] == "putEtatObjectif") {
        $statement = $connection->prepare(
          "UPDATE retrospective_objectif 
          SET retrospective_objectif_statut = :EtatObjectif 
          WHERE retrospective_objectif_pk = :id
          "
        );
        $result = $statement->execute(
          array(
            ':EtatObjectif' => $_POST["EtatObjectif"],
            ':id' => $_POST["id"]
          )
        );
        if (!empty($result))
          print true;
        else
          print_r($statement->errorInfo());
      }
      
      if ($_POST["action"] == "Créer") {
        $statement = $connection->prepare("
        INSERT INTO retrospective_objectif (retrospective_objectif_fk_sprint, retrospective_objectif_fk_projet, retrospective_objectif_fk_user, retrospective_objectif_label, retrospective_objectif_statut) 
        VALUES (:id_Sprint, :id_Projet, :id_Employe, :objectif, :id_StatutObjectif)
        ");
        $result = $statement->execute(
          array(
            ':id_Sprint' => $_POST["idSprint"],
            ':id_Projet' => $_POST["idProjet"],
            ':id_Employe' => $_POST["idEmploye"],
            ':objectif' => $_POST["LabelObjectif"],
            ':id_StatutObjectif' => 'Inconnue'
          )
        );
        if (!empty($result))
          print true;
        else
          print_r($statement->errorInfo());
      }

      if ($_POST["action"] == "getObjectif") {
        $output = array();
        $statement = $connection->prepare(
          "SELECT * FROM retrospective_objectif 
        WHERE retrospective_objectif_pk = '" . $_POST["id"] . "' 
        LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetch();

        print json_encode($result);
      }

      if ($_POST["action"] == "putObjectif") {
        $statement = $connection->prepare(
          "UPDATE retrospective_objectif 
        SET retrospective_objectif_label = :LabelObjectif, retrospective_objectif_fk_sprint = :id_Sprint, retrospective_objectif_fk_projet = :id_Projet, retrospective_objectif_fk_user = :id_Employe
        WHERE retrospective_objectif_pk = :id
        "
        );
        $result = $statement->execute(
          array(
            ':LabelObjectif' => $_POST["LabelObjectif"],
            ':id_Sprint' => $_POST["idSprint"],
            ':id_Projet' => $_POST["idProjet"],
            ':id_Employe' => $_POST["idEmploye"],
            ':id' => $_POST["id"]
          )
        );
        if (!empty($result))
          print true;
        else
          print_r($statement->errorInfo());
      }

      if ($_POST["action"] == "dellObjectif") {
        $statement = $connection->prepare(
          "DELETE FROM retrospective_objectif
        WHERE retrospective_objectif_pk = :id"
        );
        $result = $statement->execute(
          array(
            ':id' => $_POST["id"]
          )
        );
        if ($statement->rowCount() > 0)
          print true;
        else
          print_r($statement->errorInfo());
      }
    }

    ?> 