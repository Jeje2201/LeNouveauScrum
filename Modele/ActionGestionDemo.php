   <?php

  require_once('../Modele/Configs.php');

  if (isset($_POST["action"])) {

    if ($_POST["action"] == "Load") {
      $statement = $connection->prepare("SELECT D.id, E.prenom, P.nom, D.DateEffectue
      from demo D
      inner join employe E on D.id_Employe = E.id
      inner join projet P on D.id_Projet = P.id
      ORDER BY (CASE WHEN D.DateEffectue IS NULL THEN 1 ELSE 0 END) DESC, 
        D.DateEffectue DESC");
        // trier par date avec null en premier trouvé sur https://stackoverflow.com/questions/821798/order-by-date-showing-nulls-first-then-most-recent-dates
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead class="thead-light">
      <tr>
      <th width="">Date</th>
      <th width="">Ressource</th>
      <th width="">Projet</th>
      <th width=""><center>Éditer</center></th>
      </tr>
      </thead>
      <tbody id="myTable">
      ';
      if ($statement->rowCount() > 0) {
        foreach ($result as $row) {
          $output .= '
        <tr>';
          if ($row["DateEffectue"] == null)
            $output .= '<td></td>';
          else
            $output .= '<td>' . date("d/m/Y", strtotime($row["DateEffectue"])) . '</td>';
          $output .= '
        <td>' . $row["prenom"] . '</td>
        <td>' . $row["nom"] . '</td>
        <td><center><div class="btn-group" role="group" aria-label="Basic example"><button type="button" id="' . $row["id"] . '" class="btn btn-warning Get"><i class="fa fa-pencil" aria-hidden="true"></i></button><button type="button" id="' . $row["id"] . '" class="btn btn-danger delete"><i class="fa fa-times" aria-hidden="true"></i></button></div></center></td>
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

    if ($_POST["action"] == "Select") {
      $output = array();
      $statement = $connection->prepare(
        "SELECT * FROM demo 
   WHERE id = '" . $_POST["id"] . "' 
   LIMIT 1"
      );
      $statement->execute();
      $result = $statement->fetch();

      if ($result["DateEffectue"] == null)
        $output["DateEffectue"] = "";
      else
        $output["DateEffectue"] = date("d-m-Y", strtotime($result["DateEffectue"]));

      $output["Ressource"] = $result["id_Employe"];
      $output["Projet"] = $result["id_Projet"];

      echo json_encode($output);
    }

    if ($_POST["action"] == "Update") {

      if($_POST["DateEffectue"] == "undefined-undefined-")
        $_POST["DateEffectue"] = NULL;

      $statement = $connection->prepare(
        "UPDATE demo
        SET id_Employe = :id_Employe, id_Projet= :id_Projet, DateEffectue = :DateEffectue 
        WHERE id = :id"
      );
      $result = $statement->execute(
        array(
          ':id_Employe' => $_POST["Employe"],
          ':id_Projet' => $_POST["Projet"],
          ':DateEffectue' => $_POST["DateEffectue"],
          ':id' => $_POST["id"]
        )
      );
      if (!empty($result))
        echo '✓';
      else {
        print_r($statement->errorInfo());
      }
    }

    if ($_POST["action"] == "Delete") {
      $statement = $connection->prepare(
        "DELETE FROM demo WHERE id = :id"
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
