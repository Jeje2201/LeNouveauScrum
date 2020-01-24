<?php
    session_start();
    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "getDemos") {
        $statement = $connection->prepare("SELECT
        E.prenom as ressource_prenom,
        E.Initial as ressource_initial,
        P.nom as projet_nom,
        D.Label as demo_label,
        D.id as demo_id,
        D.DateEffectue as demo_DateEffectue
        FROM demo D
        INNER JOIN projet P on P.id = D.id_Projet
        INNER JOIN employe E on E.id = D.id_Employe
        ORDER BY D.DateEffectue IS NULL ASC, D.DateEffectue ASC, E.prenom DESC");
        $statement->execute();
        $result = $statement->fetchAll();

        $resultat = [];

        foreach ($result as $row) {

          $MonTest = [];

          $MonTest['ressource_prenom'] = $row['ressource_prenom'];
          $MonTest['ressource_prenom'] = $row['ressource_prenom'];
          $MonTest['ressource_initial'] = $row['ressource_initial'];
          $MonTest['projet_nom'] = $row['projet_nom'];
          $MonTest['demo_label'] = $row['demo_label'];
          $MonTest['demo_id'] = $row['demo_id'];

          if ($row["demo_DateEffectue"] == null)
            $MonTest["demo_DateEffectue"] = "";
          else
            $MonTest["demo_DateEffectue"] = date("d/m/Y", strtotime($row["demo_DateEffectue"]));

          $resultat[] = $MonTest;
        }

        print json_encode($resultat);
      }

      if ($_POST["action"] == "getDemo") {

        $statement = $connection->prepare("SELECT * FROM demo WHERE id = '" . $_POST["demo_id"] . "' LIMIT 1");
        $statement->execute();
        $result = $statement->fetch();
  
        $resultat = [];
  
        $resultat['demo_id'] = $result['id'];
        $resultat['demo_Label'] = $result['Label'];
        $resultat['demo_id_Employe'] = $result['id_Employe'];
        $resultat['demo_id_Projet'] = $result['id_Projet'];

        if ($result["DateEffectue"] == null)
            $resultat["demo_DateEffectue"] = "";
        else
            $resultat["demo_DateEffectue"] = date("d-m-Y", strtotime($result["DateEffectue"]));
  
        print json_encode($resultat);
      }

      if ($_POST["action"] == "addDemo") {
        $statement = $connection->prepare("
        INSERT INTO demo (id_Projet, id_Employe, Label) 
        VALUES (:id_Projet, :id_Employe, :Label)
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
          "UPDATE demo 
          SET DateEffectue = NOW()
          WHERE id = :id
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

        if ($_POST["DateEffectue"] == "undefined-undefined-")
          $_POST["DateEffectue"] = null;

        $statement = $connection->prepare(
          "UPDATE demo
        SET id_Employe = :id_Employe, id_Projet= :id_Projet, DateEffectue = :DateEffectue, label = :Label 
        WHERE id = :id"
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
          "DELETE FROM demo
          WHERE id = :id"
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