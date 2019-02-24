   <?php

  require_once('../Modele/Configs.php');

  if (isset($_POST["action"])) {


    //Charger la liste des images
    if ($_POST["action"] == "Load") {
      $statement = $connection->prepare("SELECT *
        FROM Logo L
        ORDER BY L.nom asc");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead class="thead-light">
      <tr>
      <th>Nom</th>
      <th width=60px>Image</th>
      <th><center>Éditer</center></th>
      </tr>
      </thead>
      <tbody id="myTable">
      ';
      if ($statement->rowCount() > 0) {
        foreach ($result AS $row) {
          $output .= '
        <tr>
        <td>' . $row["nom"] . '</td>
        <td> <img src="Assets/Image/Projets/' . $row["path"] . '" width=60px height=60px /></td>';

          $output .= '<td><center><div class="btn-group" role="group" aria-label="Basic example"><button type="button" id="' . $row["id"] . '" class="btn btn-warning update"><i class="fa fa-pencil" aria-hidden="true"></i></button><button type="button" id="' . $row["id"] . '" class="btn btn-danger delete"><i class="fa fa-times" aria-hidden="true"></i></button></div></center></td>
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

      if($_POST["ApiPivotal"] == "")
        $_POST["ApiPivotal"] = NULL;

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
          ':mdp' => password_hash($_POST["mdp"],PASSWORD_BCRYPT)
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
        ");
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
        "DELETE FROM logo WHERE id = :id"
      );
      $result = $statement->execute(
        array(
          ':id' => $_POST["id"]
        )
      );
      if (!empty($result)){

        $myFile = "../Assets/Image/Projets/" . $_POST["path"];
        if(unlink($myFile)){
          unlink($myFile)
          echo '✓';
        }
        else
          echo 'Une erreur dur a comprendre..'
      }
      else
        print_r($statement->errorInfo());
    }

    if ($_POST["action"] == "insert") {
      $target_file = basename($_FILES["image"]["name"]);
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  //Je check si l'image n'a pas déjà le meme nom dans le dossier
      if (file_exists($target_file)) {
        echo "Ce nom d'image existe déjà. Image non insérée, pas de doublon ici! bouh!";
      }

  //Check si le fichier est supérieux a 10 Mo
      else if ($_FILES["image"]["size"] > 10000000) {
        echo "Tu veux pas envoyer un fichier de la taille d'un film aussi ? Trouve plus petit (max = 1mo)";
      }

  //Si l'image convient et passe toutes les regles, alors on peut l'ajouter dans le dossier serveur
      else if(move_uploaded_file($_FILES["image"]["tmp_name"], "../Assets/Image/Projets/" . $target_file)){
        move_uploaded_file($_FILES["image"]["tmp_name"], "../Assets/Image/Projets/" . $target_file);
        
        $statement = $connection->prepare("
        INSERT INTO logo (nom, path) 
        VALUES (:nom, :path)
        ");
     
           $result = $statement->execute(
             array(
               ':nom' => $_FILES["image"]["name"],
               ':path' => $target_file
             )
           );
           if (!empty($result))
             echo '✓';
           else
             print_r($statement->errorInfo());
      }
      else
        echo "Une erreur dont je ne suis pas capable d'identifier est intervenue :/";
    }
}

  ?>
