<?php
    session_start();
    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "getDemos") {
        $statement = $connection->prepare("SELECT *
        FROM retrospective_demo
        INNER JOIN projet on projet_pk = retrospective_demo_fk_projet
        INNER JOIN user on user_pk = retrospective_demo_fk_user
        ORDER BY retrospective_demo_dateEffectue IS NULL ASC, retrospective_demo_dateEffectue ASC, user_prenom DESC");
        $statement->execute();
        $result = $statement->fetchAll();

        print json_encode($result);
      }

      if ($_POST["action"] == "getDemo") {

        $statement = $connection->prepare("SELECT *
        FROM retrospective_demo D WHERE retrospective_demo_pk = '" . $_POST["demo_id"] . "' LIMIT 1");
        $statement->execute();
        $result = $statement->fetch();
          
        print json_encode($result);
      }

      if ($_POST["action"] == "addDemo") {
        $statement = $connection->prepare("
        INSERT INTO retrospective_demo (retrospective_demo_fk_projet, retrospective_demo_fk_user, retrospective_demo_label, retrospective_demo_dateCree) 
        VALUES (:id_Projet, :id_Employe, :Label, NOW())
        ");
        $result = $statement->execute(
          array(
            ':id_Projet' => $_POST["idProjet"],
            ':Label' => $_POST["LabelDemo"],
            ':id_Employe' => $_POST["idEmploye"]
          )
        );
        if (!empty($result))
          print true;
        else
          print_r($statement->errorInfo());
      }

      if ($_POST["action"] == "achieveDemo") {
        $statement = $connection->prepare(
          "UPDATE retrospective_demo 
          SET retrospective_demo_dateEffectue = NOW()
          WHERE retrospective_demo_pk = :id
          "
        );
        $result = $statement->execute(
          array(
            ':id' => $_POST["demo_id"]
          )
        );
        if (!empty($result))
          print true;
        else
          print_r($statement->errorInfo());
      }

      if ($_POST["action"] == "putDemo") {

        if ($_POST["DateEffectue"] == "")
          $_POST["DateEffectue"] = null;

        $statement = $connection->prepare(
          "UPDATE retrospective_demo
        SET retrospective_demo_fk_user = :id_Employe, retrospective_demo_fk_projet= :id_Projet, retrospective_demo_dateCree = :DateCree, retrospective_demo_dateEffectue = :DateEffectue, retrospective_demo_label = :Label 
        WHERE retrospective_demo_pk = :id"
        );
        $result = $statement->execute(
          array(
            ':id_Employe' => $_POST["Employe"],
            ':id_Projet' => $_POST["Projet"],
            ':DateCree' => $_POST["DateCree"],
            ':DateEffectue' => $_POST["DateEffectue"],
            ':Label' => $_POST["LabelDemo"],
            ':id' => $_POST["id"]
          )
        );
        if (!empty($result))
          print true;
        else
          print_r($statement->errorInfo());
      }

      if ($_POST["action"] == "dellDemo") {
        $statement = $connection->prepare(
          "DELETE FROM retrospective_demo
          WHERE retrospective_demo_pk = :id"
        );
        $result = $statement->execute(
          array(
            ':id' => $_POST["demo_id"]
          )
        );
        if ($statement->rowCount() > 0)
          print true;
      }
    }
    ?> 