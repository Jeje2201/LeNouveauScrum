   <?php
  require_once('../Modele/Configs.php');

  if (isset($_POST["action"])) {

    if ($_POST["action"] == "Load") {
      $statement = $connection->prepare("SELECT id,
      ApiPivotal,
      nom,
      Logo,
      (
        SELECT nom
        FROM typeprojet T
        WHERE T.id = P.id_TypeProjet
      ) AS TypeProjet
      FROM projet P
      ORDER BY P.nom asc");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead class="thead-light">
      <tr>
      <th>Nom</th>
      <th>Type</th>
      <th>ID Pivotal</th>
      <th>Icone</th>
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
        <td>' . $row["TypeProjet"] . '</td>
        <td>' . $row["ApiPivotal"] . '</td>';
          $output .= '<td><img src="Assets/Image/Projets/' . $row['Logo'] . '" alt="MrJeje" width="35px" height="35px"/></td>
        <td><center><div class="btn-group" role="group" aria-label="Basic example"><button type="button" id="' . $row["id"] . '" class="btn btn-warning update"><i class="fa fa-pencil" aria-hidden="true"></i></button><button type="button" id="' . $row["id"] . '" class="btn btn-danger delete"><i class="fa fa-times" aria-hidden="true"></i></button></div></center></td>
        </tr>
        ';
        }
      } else {
        print_r($statement->errorInfo());

        $output .= '
     <tr>
     <td align="center" colspan="10">Pas de données</td>
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

      foreach ($files AS $file) {
        if ($file == "Inconnue.png")
          $output2 .= '<option value="' . $file . '" selected> ' . substr($file, 0, -4) . ' </option>';
        else
          $output2 .= '<option value="' . $file . '"> ' . substr($file, 0, -4) . ' </option>';

      }

      $output2 .= '</select>';

      echo $output2;
    }


    if ($_POST["action"] == "Ajouter") {

      if($_POST["ApiPivotal"] == "")
        $_POST["ApiPivotal"] = NULL;

      $statement = $connection->prepare("
   INSERT INTO projet (nom, Logo, id_TypeProjet, ApiPivotal) 
   VALUES (:Nom, :Logo, :id_TypeProjet, :ApiPivotal)
   ");

      $result = $statement->execute(
        array(
          ':Nom' => $_POST["Nom"],
          ':Logo' => $_POST["fileName"],
          ':id_TypeProjet' => $_POST["TypeProjet"],
          ':ApiPivotal' => $_POST["ApiPivotal"]
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
      $result = $statement->fetch();

        $output["Nom"] = $result["nom"];
        $output["Logo"] = $result["Logo"];
        $output["ApiPivotal"] = $result["ApiPivotal"];
        $output["TypeProjet"] = $result["id_TypeProjet"];

      echo json_encode($output);
    }

    if ($_POST["action"] == "Update") {

      if($_POST["ApiPivotal"] == "")
        $_POST["ApiPivotal"] = NULL;

      $statement = $connection->prepare(
        "UPDATE projet 
   SET nom = :nom, Logo = :Logo, id_TypeProjet = :id_TypeProjet, ApiPivotal = :ApiPivotal
   WHERE id = :id
   "
      );
      $result = $statement->execute(
        array(
          ':nom' => $_POST["Nom"],
          ':ApiPivotal' => $_POST["ApiPivotal"],
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
        "DELETE FROM projet
         WHERE id = :id"
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
  }

  ?>
