   <?php
    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {


    if ($_POST["action"] == "GetChangelogs") {
      $output = array();
      $statement = $connection->prepare(
        "SELECT * FROM changelog ORDER BY changelog_numero desc"
      );
      $statement->execute();
      $result = $statement->fetchAll();

      $resultat = [];

      foreach ($result as $row) {
        $resultat[] = $row;
      }

      print json_encode($resultat);
    }

  }

?> 