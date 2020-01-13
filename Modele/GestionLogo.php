   <?php

    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {


      //Charger la liste des images
      if ($_POST["action"] == "Load") {
        $statement = $connection->prepare("SELECT *
        FROM logo L
        ORDER BY L.nom asc");
        $statement->execute();
        $result = $statement->fetchAll();
        $output = '';
        $output .= '
      <table class="table table-sm table-striped table-bordered" id="datatable" cellspacing="0">
      <thead class="thead-light">
      <tr>
      <th>Nom</th>
      <th>Image</th>
      <th><center>Éditer</center></th>
      </tr>
      </thead>
      <tbody id="myTable">
      ';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {
            $output .= '
        <tr>
        <td>' . $row["nom"] . '</td>
        <td style="width:60px"> <img src="' . $row["base64"] . '" width=60px height=60px /></td>';

            $output .= '<td><center><div class="btn-group" role="group" ><button type="button" id="' . $row["id"] . '" class="btn btn-warning update"><i class="fa fa-pencil" aria-hidden="true"></i></button><button type="button" id="' . $row["id"] . '" class="btn btn-danger delete"><i class="fa fa-times" aria-hidden="true"></i></button></div></center></td>
        </tr>
        ';
          }
        } else {
          $output .= '
     <tr>
     <td align="center" colspan="10">Pas de données</td>
     </tr>
     ';
        }
        $output .= '</tbody></table>';
        echo $output;
      }

      //Ajouter des images
      if ($_POST["action"] == "Ajouter") {

        if ($_POST["ApiPivotal"] == "")
          $_POST["ApiPivotal"] = null;

        $statement = $connection->prepare("
   INSERT INTO employe (prenom, nom, Pseudo, Couleur, actif, Initial, id_TypeEmploye, mdp, ApiPivotal) 
   VALUES (:prenom, :nom, :pseudo, :Couleur, :actif, :Initial, :Type_Employe, :mdp, :ApiPivotal)
   ");

        $result = $statement->execute(
          array(
            ':prenom' => $_POST["Prenom_Employe"],
            ':pseudo' => $_POST["Prenom_Employe"],
            ':nom' => $_POST["Nom_Employe"],
            ':Couleur' => '#' . random_color(),
            ':actif' => $_POST["Actif"],
            ':Initial' => $_POST["Initial"],
            ':ApiPivotal' => $_POST["ApiPivotal"],
            ':Type_Employe' => $_POST["Type_Employe"],
            ':mdp' => password_hash($_POST["mdp"], PASSWORD_BCRYPT)
          )
        );
        if (!empty($result))
          echo '✓';
        else
          print_r($statement->errorInfo());
      }

      //envoyer les infos pour get et edit
      if ($_POST["action"] == "Select") {
        $output = array();
        $statement = $connection->prepare(
          "SELECT * FROM logo 
         WHERE id = '" . $_POST["id"] . "' 
         LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetch();

        $output["Nom"] = $result["nom"];

        echo json_encode($output);
      }

      //mettre a jours les infos
      if ($_POST["action"] == "Update") {

        $statement = $connection->prepare(
          "UPDATE logo 
        SET nom = :nom
        WHERE id = :id
        "
        );
        $result = $statement->execute(
          array(
            ':nom' => $_POST["Nom"],
            ':id' => $_POST["id"]
          )
        );
        if (!empty($result))
          echo '✓';
        else
          print_r($statement->errorInfo());
      }

      //Supprimer une image
      if ($_POST["action"] == "Delete") {

        $statement = $connection->prepare(
          "UPDATE projet P
        SET Id_Logo = (select id from logo where logo.nom like 'Inconnue')
        WHERE P.Id_Logo = :id
        "
        );
        $result = $statement->execute(
          array(
            ':id' => $_POST["id"]
          )
        );
        if (!empty($result))
          echo 'Le projet à maintenant la miniature Inconnue.';
        else
          print_r($statement->errorInfo());

        $statement = $connection->prepare(
          "DELETE FROM logo WHERE id = :id"
        );
        $result = $statement->execute(
          array(
            ':id' => $_POST["id"]
          )
        );
      }

      if ($_POST["action"] == "insert") {

        $statement = $connection->prepare("
          INSERT INTO logo (nom, base64) 
          VALUES (:nom, :base64)
        ");

        $result = $statement->execute(
          array(
            ':nom' => $_POST["imgName"],
            ':base64' => $_POST["img64"]
          )
        );

        if ($statement->rowCount() > 0)
          echo '✓';
        else
          print_r($statement->errorInfo());
      }
    }

    ?> 