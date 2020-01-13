   <?php
    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "DescriptionProjet") {
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

        echo json_encode($output);
      }

      if ($_POST["action"] == "DescriptionClient") {
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

        echo json_encode($output);
      }

      if ($_POST["action"] == "RessourcesProjet") {
        $output = array();
        $statement = $connection->prepare(
          "SELECT E.prenom, E.avatar, T.nom as job FROM employe E
           INNER JOIN typeemploye T on E.id_TypeEmploye = T.id
           WHERE E.id in (select R.id_ressource from ressourceprojet R where R.id_projet = " . $_POST["projectId"] . ")"
        );
        $statement->execute();
        $result = $statement->fetchAll();

        $resultat = [];

        foreach ($result as $row) {

          $MonTest = [];

          $MonTest['Prenom'] = $row['prenom'];
          $MonTest['Avatar'] = $row['avatar'];
          $MonTest['Job'] = $row['job'];

          $resultat[] = $MonTest;
        }

        print json_encode($resultat);
      }
      
      if ($_POST["action"] == "AddRessource") {
        $statement = $connection->prepare(
        "INSERT INTO ressourceprojet (id_projet, id_ressource) 
        VALUES (:id_projet, :id_ressource)
        ");
        $result = $statement->execute(
          array(
            ':id_projet' => $_POST["projectId"],
            ':id_ressource' => $_POST["UserId"]
          )
        );
        if (!empty($result))
          echo 'User "'.$_POST["UserId"].'" ajoutée';
        else
          print_r($statement->errorInfo());
    }

      if ($_POST["action"] == "GetTechno") {
        $output = array();
        $statement = $connection->prepare(
          "SELECT T.technologie FROM technologieprojet T
           WHERE T.id_projet = " . $_POST["projectId"]
        );
        $statement->execute();
        $result = $statement->fetchAll();

        $resultat = [];

        foreach ($result as $row) {

          $resultat[] = $row['technologie'];
        }

        print json_encode($resultat);
      }

      if ($_POST["action"] == "AddTechno") {
          $statement = $connection->prepare(
          "INSERT INTO technologieprojet (technologie, id_projet) 
          VALUES (:technologie, :id_projet)
          ");
          $result = $statement->execute(
            array(
              ':technologie' => $_POST["NouvelleTechno"],
              ':id_projet' => $_POST["projectId"]
            )
          );
          if (!empty($result))
            echo 'Tehcno "'.$_POST["NouvelleTechno"].'" ajoutée';
          else
            print_r($statement->errorInfo());
      }

      if ($_POST["action"] == "DellTechno") {

        $statement = $connection->prepare(
          "DELETE FROM technologieprojet
          WHERE technologie like :technologie
          AND id_projet = :id_projet"
        );
        $result = $statement->execute(
          array(
            ':technologie' => $_POST["NouvelleTechno"],
            ':id_projet' => $_POST["projectId"]
          )
        );
        if (!empty($result))
          echo 'Techno "'.$_POST["NouvelleTechno"].'" supprimée';
        else
          print_r($statement->errorInfo());
    }
    }

    ?> 