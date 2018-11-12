   <?php
  require_once('../Modele/Configs.php');

  if (isset($_POST["action"])) {

    if ($_POST["action"] == "Load") {
      $statement = $connection->prepare("SELECT id , nom as Nom, Logo, (select nom from typeprojet where typeprojet.id = projet.id_TypeProjet ) as TypeProjet FROM projet ORDER BY projet.nom asc");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead class="thead-light">
      <tr>
      <th>Nom</th>
      <th>Type</th>
      <th>Icone</th>
      <th><center>Éditer</center></th>
      </tr>
      </thead>
      <tbody id="myTable">
      ';
      if ($statement->rowCount() > 0) {
        foreach ($result as $row) {
          $output .= '
        <tr>
        <td>' . $row["Nom"] . '</td>
        <td>' . $row["TypeProjet"] . '</td>';
          $output .= '<td><img src="Assets/Image/Projets/' . $row['Logo'] . '" alt="MrJeje" width="35px" height="35px"/></td>
        <td><center><div class="btn-group" role="group" aria-label="Basic example"><button type="button" id="' . $row["id"] . '" class="btn btn-warning update"><i class="fa fa-pencil" aria-hidden="true"></i></button><button type="button" id="' . $row["id"] . '" class="btn btn-danger delete"><i class="fa fa-times" aria-hidden="true"></i></button></div></center></td>
        </tr>
        ';
        }
      } else {
        print_r($statement->errorInfo());

        $output .= '
     <tr>
     <td align="center">0 donnée</td>
     </tr>
     ';
      }
      $output .= '</tbody></table>';
      echo $output;
    }

    if ($_POST["action"] == "LoadPictures") {
      $dir = '../Assets/Image/Projets/';
      $files = array_diff(scandir($dir), array('..', '.'));

      $output2 = '<select class="form-control"  id="ToutesLesImages" name="ToutesLesImages">';

      foreach ($files as $file) {
        if ($file == "Inconnue.png")
          $output2 .= '<option value="' . $file . '" selected> ' . substr($file, 0, -4) . ' </option>';
        else
          $output2 .= '<option value="' . $file . '"> ' . substr($file, 0, -4) . ' </option>';

      }

      $output2 .= '</select>';

      echo $output2;
    }


    if ($_POST["action"] == "Ajouter") {
      $statement = $connection->prepare("
   INSERT INTO projet (nom, Logo, id_TypeProjet) 
   VALUES (:Nom, :Logo, :id_TypeProjet)
   ");

      $result = $statement->execute(
        array(
          ':Nom' => $_POST["Nom"],
          ':Logo' => $_POST["fileName"],
          ':id_TypeProjet' => $_POST["TypeProjet"]
        )
      );
      if (!empty($result))
        echo '✓';
      else
        print_r($statement->errorInfo());
    }

    if ($_POST["action"] == "Select") {
      $output = array();
      $statement = $connection->prepare(
        "SELECT * FROM projet 
   WHERE id = '" . $_POST["id"] . "' 
   LIMIT 1"
      );
      $statement->execute();
      $result = $statement->fetchAll();
      foreach ($result as $row) {
        $output["Nom"] = $row["nom"];
        $output["Logo"] = $row["Logo"];
        $output["TypeProjet"] = $row["id_TypeProjet"];
      }
      echo json_encode($output);
    }

    if ($_POST["action"] == "Update") {
      $statement = $connection->prepare(
        "UPDATE projet 
   SET nom = :nom, Logo =:Logo, id_TypeProjet = :id_TypeProjet
   WHERE id = :id
   "
      );
      $result = $statement->execute(
        array(
          ':nom' => $_POST["Nom"],
          ':Logo' => $_POST["fileName"],
          ':id_TypeProjet' => $_POST["TypeProjet"],
          ':id' => $_POST["id"]
        )
      );
      if (!empty($result))
        echo '✓';
      else
        print_r($statement->errorInfo());
    }

    if ($_POST["action"] == "Delete") {
      $statement = $connection->prepare(
        "DELETE FROM projet WHERE id = :id"
      );
      $result = $statement->execute(
        array(
          ':id' => $_POST["id"]
        )
      );
      if (!empty($result))
        echo '✓';
      else
        print_r($statement->errorInfo());
    }

    if ($_POST["action"] == "insert") {
      $target_dir = "../Asseuihiuhts/Image/Projets/";
      $target_file = $target_dir . basename($_FILES["image"]["name"]);
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  //Je check si l'image n'a pas déjà le meme nom dans le dossier
      if (file_exists($target_file)) {
        echo "Ce nom d'image existe déjà. Image non insérée, pas de doublon ici! bouh!";
      }

  //Check si le fichier est supérieux a 1 Mo
      else if ($_FILES["image"]["size"] > 1000000) {
        echo "Tu veux pas envoyer un fichier de la taille d'un film aussi ? Trouve plus petit (max = 1mo)";
      }

  //Check si fichier est bien soit jpg png jpeg gif
      else if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "C'est quoi ce fichier ? Moi je veux que du jpg ou png ou jpeg ou gif :)";
      }

    //Check si l'image a des espaces ou accent
      else if (preg_match("#[\s]#", basename($_FILES["image"]["name"]))) {
        echo "Ton image contient des espaces, enlève moi ça :(";
      }

  //Si l'image convient et passe toutes les regles, alors on peut l'ajouter dans le dossier serveur
      else {
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        echo "Image bien ajoutée ! " . $target_file ;
      }
    }
  }

  ?>
