   <?php
    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {


    if ($_POST["action"] == "GetChangelogs") {
      $output = array();
      $statement = $connection->prepare(
        "SELECT * FROM changelog ORDER BY changelog_date desc"
      );
      $statement->execute();
      $result = $statement->fetchAll();

      print json_encode($result);
    }

  }

?> 