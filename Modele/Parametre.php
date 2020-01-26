   <?php
    session_start();
    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      $idRessource = $_SESSION["IdUtilisateur"];

      if ($_POST["action"] == "GetColor") {

        $array = [];

        $statement = $connection->prepare(
          $sql = "SELECT Couleur
        FROM employe E
        WHERE E.id = $idRessource"
        );
        $statement->execute();
        $result = $statement->fetch();
        print trim($result["Couleur"]);
      }

      if ($_POST["action"] == "GetAvatar") {

        $output = array();
        $statement = $connection->prepare(
          "SELECT * FROM employe 
         WHERE id = $idRessource
         LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetch();

        $output["avatar"] = $result["avatar"];

        print json_encode($output);
      }

      if ($_POST["action"] == "LoadTacheValide") {
        $output = array();
        $statement = $connection->prepare(
        "SELECT sum(heure) as 'Temps', projet.nom as 'Projets' FROM `tache` INNER JOIN projet on tache.id_Projet = projet.id where id_Employe = " . $idRessource . " and Done is not null group by id_Projet order by Temps desc");
        
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
            <td>' . $row["Projets"] . '</td>
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
          "UPDATE employe 
        SET Couleur = :Couleur
        WHERE id = :id"
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

      if ($_POST["action"] == "Update") {
        $statement = $connection->prepare(
          "UPDATE employe 
        SET mdp = :mdp
        WHERE id = :id"
        );
        $result = $statement->execute(
          array(
            ':mdp' => password_hash($_POST["mdp"], PASSWORD_BCRYPT),
            ':id' => $idRessource
          )
        );
        if (!empty($result))
          print 'Nouveau mot de passe créé';
        else
          print_r($statement->errorInfo());
      }
    }

    ?> 