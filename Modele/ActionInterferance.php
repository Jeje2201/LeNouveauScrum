   <?php

  require_once('../Modele/Configs.php');

  if (isset($_POST["action"])) {

    if ($_POST["action"] == "Load") {
      $numero = $_POST["idAffiche"];
      $statement = $connection->prepare("SELECT interference.id as id,
      interference.heure as Heure,
      interference.label as Label,
      CONCAT(employe.prenom,' ', employe.initial) as Employe,
      projet.nom as Projet,
      typeinterference.nom as Type
      
      FROM interference
      INNER join employe on employe.id = interference.id_Employe
      INNER JOIN projet on projet.id = interference.id_Projet
      INNER JOIN typeinterference on typeinterference.id = interference.id_TypeInterference
      Where interference.id_Sprint = $numero ORDER BY interference.id_Projet asc");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead class="thead-light">
      <tr>
      <th>Heures</th>
      <th>Ressource</th>
      <th>Projet</th>
      <th>Type</th>
      <th>Label</th>
      <th><center>Éditer</center></th>
      </tr>
      </thead>
      <tbody id="myTable">
      ';
      if ($statement->rowCount() > 0) {
        foreach ($result as $row) {
          $output .= '
        <tr>
        <td>' . $row["Heure"] . '</td>
        <td>' . $row["Employe"] . '</td>
        <td>' . $row["Projet"] . '</td>
        <td>' . $row["Type"] . '</td>
        <td>' . $row["Label"] . '</td>
        <td><center><div class="btn-group" role="group" aria-label="Basic example"><button type="button" id="' . $row["id"] . '" class="btn btn-warning update"><i class="fa fa-pencil" aria-hidden="true"></i></button><button type="button" id="' . $row["id"] . '" class="btn btn-danger delete"><i class="fa fa-times" aria-hidden="true"></i></button></div></center></td>
        </tr>
        ';
        }
      } else {
        $output .= '
     <tr>
     <td align="center" colspan="10">0 donnée</td>
     </tr>
     ';
      }
      $output .= '</tbody></table>';
      echo $output;
    }

    if ($_POST["action"] == "Ajouter") {
      $statement = $connection->prepare("
   INSERT INTO interference (heure, id_TypeInterference, id_Sprint, id_Projet, id_Employe, label) 
   VALUES (:heure, :typeinterference, :sprint, :projet, :employe, :label)
   ");

      $result = $statement->execute(
        array(
          ':heure' => $_POST["NbHeure"],
          ':typeinterference' => $_POST["TypeInterferance"],
          ':sprint' => $_POST["idAffichee"],
          ':projet' => $_POST["Projet"],
          ':label' => $_POST["labelinterference"],
          ':employe' => $_POST["Employe"]
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
        "SELECT * FROM interference 
   WHERE id = '" . $_POST["id"] . "' 
   LIMIT 1"
      );
      $statement->execute();
      $result = $statement->fetchAll();
      foreach ($result as $row) {
        $output["Heure"] = $row["heure"];
        $output["TypeInterferance"] = $row["id_TypeInterference"];
        $output["Sprint"] = $row["id_Sprint"];
        $output["Projet"] = $row["id_Projet"];
        $output["Employe"] = $row["id_Employe"];
        $output["labelinterference"] = $row["label"];
      }
      echo json_encode($output);
    }

    if ($_POST["action"] == "Update") {
      $statement = $connection->prepare(
        "UPDATE interference 
   SET heure = :heure, id_TypeInterference = :typeinterference, id_Sprint =:sprint, id_Projet = :projet, id_Employe = :employe, label = :label
   WHERE id = :id
   "
      );
      $result = $statement->execute(
        array(
          ':heure' => $_POST["NbHeure"],
          ':typeinterference' => $_POST["TypeInterferance"],
          ':sprint' => $_POST["idAffichee"],
          ':projet' => $_POST["Projet"],
          ':employe' => $_POST["Employe"],
          ':label' => $_POST["labelinterference"],
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
        "DELETE FROM interference WHERE id = :id"
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
