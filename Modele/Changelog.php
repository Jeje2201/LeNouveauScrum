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

        $Groupe = [];

        $Groupe['changelog_numero'] = $row['changelog_numero'];
        $Groupe['changelog_date'] = date("d/m/Y", strtotime($row['changelog_date']));
        $Groupe['changelog_contenue'] = $row['changelog_contenue'];
        $Groupe['changelog_meme'] = $row['changelog_meme'];

        // $Groupe['date_echange'] = date("d/m/Y", strtotime($row['date_echange']));

        $resultat[] = $Groupe;
      }

      print json_encode($resultat);
    }

  }

?> 