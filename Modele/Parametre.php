   <?php
    session_start();
    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      $idRessource = $_SESSION['user']['id'];

      if ($_POST["action"] == "GetColor") {

        $array = [];

        $statement = $connection->prepare(
          $sql = "SELECT user_couleur
        FROM user
        WHERE user_pk = $idRessource"
        );
        $statement->execute();
        $result = $statement->fetch();
        print trim($result["user_couleur"]);
      }

      if ($_POST["action"] == "GetAvatar") {

        $output = array();
        $statement = $connection->prepare(
          "SELECT * FROM user 
         WHERE user_pk = $idRessource
         LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetch();

        $output["avatar"] = $result["user_avatar"];

        print json_encode($output);
      }

      if ($_POST["action"] == "LoadTacheValide") {
        $output = array();
        $statement = $connection->prepare(
        "SELECT sum(tache_heure) as 'Temps',
        projet_nom
        FROM `tache`
        INNER JOIN projet on tache_fk_projet = projet_pk
        where tache_fk_user = " . $idRessource . "
        and tache_done is not null
        group by tache_fk_projet
        order by Temps desc");
        
        $statement->execute();
        $result = $statement->fetchAll();
        $output = '';
        $output .= '
        <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
        <thead class="thead-light">
        <tr>
        <th width="">Projet</th>
        <th width="">Total</th>
        </tr>
        </thead>
        <tbody id="myTable">
        ';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {

            $output .= '
            <tr>
            <td>' . $row["projet_nom"] . '</td>
            <td>' . $row["Temps"] . 'h</td>
            </tr>';
          }
        } else {
          $output .= '
          <tr>
            <td align="center" colspan="10">Pas de données</td>
          </tr>';
        }
        $output .= '</tbody></table>';
        print $output;
      }

      if ($_POST["action"] == "CustomColorName") {
        $statement = $connection->prepare(
          "UPDATE user 
        SET user_couleur = :Couleur
        WHERE user_pk = :id"
        );
        $result = $statement->execute(
          array(
            ':Couleur' => $_POST["couleur"],
            ':id' => $idRessource 
          )
        );
        if (!empty($result))
          print 'Couleur de tâche changée en '.$_POST["couleur"];
        else
          print_r($statement->errorInfo());
      }
    }

    ?> 