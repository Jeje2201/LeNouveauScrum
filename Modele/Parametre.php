   <?php
    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "Load") {

        $array = [];
        $idRessource = $_POST["idRessource"];

        $statement = $connection->prepare(
          $sql = "SELECT Couleur
        FROM employe E
        WHERE E.id = $idRessource"
        );
        $statement->execute();
        $result = $statement->fetch();
        echo " ";
        echo $result["Couleur"];
      }

      if ($_POST["action"] == "CustomColorName") {
        $statement = $connection->prepare(
          "UPDATE employe 
        SET Couleur = :Couleur
        WHERE id = :id"
        );
        $result = $statement->execute(
          array(
            ':Couleur' => $_POST["couleur"],
            ':id' => $_POST["idRessource"]
          )
        );
        if (!empty($result))
          echo '✓';
        else
          print_r($statement->errorInfo());
      }

      if ($_POST["action"] == "Update") {
        $statement = $connection->prepare(
          "UPDATE employe 
        SET mdp = :mdp
        WHERE id = :id"
        );
        $result = $statement->execute(
          array(
            ':mdp' => password_hash($_POST["mdp"], PASSWORD_BCRYPT),
            ':id' => $_POST["idRessource"]
          )
        );
        if (!empty($result))
          echo '✓';
        else
          print_r($statement->errorInfo());
      }
    }

    ?> 