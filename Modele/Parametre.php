   <?php
    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "GetColor") {

        $array = [];
        $idRessource = $_POST["idRessource"];

        $statement = $connection->prepare(
          $sql = "SELECT Couleur
        FROM employe E
        WHERE E.id = $idRessource"
        );
        $statement->execute();
        $result = $statement->fetch();
        echo trim($result["Couleur"]);
      }

      if ($_POST["action"] == "LoadTacheValide") {
        $output = array();
        $statement = $connection->prepare(
        "SELECT sum(heure) as 'Temps', projet.nom as 'Projets' FROM `attribution` INNER JOIN projet on attribution.id_Projet = projet.id where id_Employe = '" . $_POST["idRessource"] . "' and Done is not null group by id_Projet order by Temps desc");
        
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
        echo $output;
      }

      //List des heures par sprint de rempli
      if ($_POST["action"] == "LoadFicheDeTempsValide") {
        $output = array();
        $statement = $connection->prepare(
        "SELECT sum(cir.Time) as 'Temps', projet.nom as 'Projets' from cir inner join projet on cir.Fk_Project = projet.id where Fk_User = '" . $_POST["idRessource"] . "' group by Fk_Project order by Temps desc");
        
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

            $num = $row["Temps"];
            $hours = ($num / 60);
            $rhours = floor($hours);
            $minutes = ($hours - $rhours) * 60;
            $rminutes = round($minutes);
            if($rminutes < 10){
              $rminutes = "0".$rminutes;
            }

            if($rhours < 10){
              $rhours = "0".$rhours;
            }

            $output .= '
            <tr>
            <td>' . $row["Projets"] . '</td>
            <td>' . $rhours . 'h' . $rminutes . '</td>
            </tr>';
          }
        } else {
          $output .= '
          <tr>
            <td align="center" colspan="10">Pas de données</td>
          </tr>';
        }
        $output .= '</tbody></table>';
        echo $output;
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
          echo 'Couleur de tâche changée';
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
          echo 'Nouveau mot de passe créé';
        else
          print_r($statement->errorInfo());
      }
    }

    ?> 