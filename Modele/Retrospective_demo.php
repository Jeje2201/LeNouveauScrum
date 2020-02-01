<?php
    session_start();
    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "getDemos") {
        $statement = $connection->prepare("SELECT *
        FROM retrospective_demo D
        INNER JOIN projet P on P.projet_pk = D.demo_fk_Projet
        INNER JOIN employe E on E.id = D.demo_fk_Employe
        ORDER BY D.demo_DateEffectue IS NULL ASC, D.demo_DateEffectue ASC, E.prenom DESC");
        $statement->execute();
        $result = $statement->fetchAll();

        print json_encode($result);
      }

      if ($_POST["action"] == "getDemo") {

        $statement = $connection->prepare("SELECT *
        FROM retrospective_demo D WHERE demo_pk = '" . $_POST["demo_id"] . "' LIMIT 1");
        $statement->execute();
        $result = $statement->fetch();
          
        print json_encode($result);
      }

      if ($_POST["action"] == "addDemo") {
        $statement = $connection->prepare("
        INSERT INTO retrospective_demo (demo_fk_Projet, demo_fk_Employe, demo_Label, demo_DateCree) 
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
      }

      if ($_POST["action"] == "achieveDemo") {
        $statement = $connection->prepare(
          "UPDATE retrospective_demo 
          SET demo_DateEffectue = NOW()
          WHERE demo_pk = :id
          "
        );
        $result = $statement->execute(
          array(
            ':id' => $_POST["demo_id"]
          )
        );
        if (!empty($result))
          print true;
      }

      if ($_POST["action"] == "putDemo") {

        if ($_POST["DateEffectue"] == "")
          $_POST["DateEffectue"] = null;

        $statement = $connection->prepare(
          "UPDATE retrospective_demo
        SET demo_fk_Employe = :id_Employe, demo_fk_Projet= :id_Projet, demo_DateEffectue = :DateEffectue, demo_Label = :Label 
        WHERE demo_pk = :id"
        );
        $result = $statement->execute(
          array(
            ':id_Employe' => $_POST["Employe"],
            ':id_Projet' => $_POST["Projet"],
            ':DateEffectue' => $_POST["DateEffectue"],
            ':Label' => $_POST["LabelDemo"],
            ':id' => $_POST["id"]
          )
        );
        if (!empty($result))
          print true;
      }

      if ($_POST["action"] == "dellDemo") {
        $statement = $connection->prepare(
          "DELETE FROM retrospective_demo
          WHERE demo_pk = :id"
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