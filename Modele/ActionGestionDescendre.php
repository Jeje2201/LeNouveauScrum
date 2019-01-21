   <?php

  require_once('../Modele/Configs.php');

  if (isset($_POST["action"])) {

    if ($_POST["action"] == "Load") {
      $numero = $_POST["idAffiche"];
      $statement = $connection->prepare("SELECT heuresdescendues.id as id, heuresdescendues.heure as NbHeure, heuresdescendues.DateDescendu as Datee, projet.nom as projet, employe.prenom as employe FROM heuresdescendues inner JOIN employe ON heuresdescendues.id_Employe = employe.id INNER JOIN projet on projet.id = heuresdescendues.id_Projet INNER JOIN sprint on sprint.id = heuresdescendues.id_Sprint WHERE id_sprint= $numero ORDER BY heuresdescendues.id desc");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead class="thead-light">
      <tr>
      <th>Ressource</th>
      <th>Projet</th>
      <th>Date</th>
      <th>H</th>
      <th><center>Éditer</center></th>
      </tr>
      </thead>
      <tbody id="myTable">
      ';
      if ($statement->rowCount() > 0) {
        foreach ($result as $row) {
          $output .= '
        <tr>
        <td>' . $row["employe"] . '</td>
        <td>' . $row["projet"] . '</td>
        <td>' . date("d-m-Y", strtotime($row["Datee"])) . '</td>
        <td>' . $row["NbHeure"] . '</td>
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

    if ($_POST["action"] == "Valider") {
      $statement = $connection->prepare("
   INSERT INTO heuresdescendues (heure, DateDescendu, id_Sprint, id_Employe, id_Projet) 
   VALUES (:NombreHeure, :DateDescendu, :idSprint, :idEmploye, :idProjet)
   ");
      $result = $statement->execute(
        array(
          ':NombreHeure' => $_POST["NombreHeure"],
          ':DateDescendu' => $_POST["DateAujourdhui"],
          ':idSprint' => $_POST["idSprint"],
          ':idEmploye' => $_POST["idEmploye"],
          ':idProjet' => $_POST["idProjet"]
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
        "SELECT * FROM heuresdescendues 
   WHERE id = '" . $_POST["id"] . "' 
   LIMIT 1"
      );
      $statement->execute();
      $result = $statement->fetchAll();
      foreach ($result as $row) {
        $output["heure"] = $row["heure"];
        $output["DateAujourdhui"] = date("d-m-Y", strtotime($row["DateDescendu"]));
        $output["id_Employe"] = $row["id_Employe"];
        $output["id_Projet"] = $row["id_Projet"];
      }
      echo json_encode($output);
    }

    if ($_POST["action"] == "Update") {
      $statement = $connection->prepare(
        "UPDATE heuresdescendues
   SET heure = :heure, id_Sprint = :id_Sprint, id_Projet = :id_Projet, DateDescendu = :DateDescendu, id_Employe = :id_Employe 
   WHERE id = :id
   "
      );
      $result = $statement->execute(
        array(
          ':heure' => $_POST["NombreHeure"],
          ':DateDescendu' => $_POST["DateAujourdhui"],
          ':id_Sprint' => $_POST["idSprint"],
          ':id_Projet' => $_POST["idProjet"],
          ':id_Employe' => $_POST["idEmploye"],
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
        "DELETE FROM heuresdescendues WHERE id = :id"
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
