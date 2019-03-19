   <?php

    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      //Afficher toutes les taches pour un sprint selectionné
      if ($_POST["action"] == "Load") {
        $numero = $_POST["idAffiche"];
        $statement = $connection->prepare("SELECT A.id AS id,
      A.heure,
      A.Done,
      A.Label,
      P.nom AS projet,
      CONCAT(E.prenom,' ', E.initial) AS employe
      FROM attribution A
      inner JOIN employe E ON A.id_Employe = E.id
      INNER JOIN projet P on P.id = A.id_Projet
      INNER JOIN sprint S on S.id = A.id_Sprint
      WHERE A.id_sprint = $numero
      ORDER BY A.id DESC");
        $statement->execute();
        $result = $statement->fetchAll();
        $output = '';
        $output .= '
      <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead class="thead-light">
      <tr>
      <th>Ressource</th>
      <th>Projet</th>
      <th>Fini le</th>
      <th>Label</th>
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
        <td>' . $row["projet"] . '</td>';
            if ($row["Done"] == null)
              $output .= '<td></td>';
            else
              $output .= '<td>' . date("d/m/Y", strtotime($row["Done"])) . '</td>';
            $output .= '
        <td>' . $row["Label"] . '</td>
        <td>' . $row["heure"] . '</td>
        <td><center><div class="btn-group" role="group" aria-label="Basic example"><button type="button" id="' . $row["id"] . '" class="btn btn-warning update"><i class="fa fa-pencil" aria-hidden="true"></i></button><button type="button" id="' . $row["id"] . '" class="btn btn-danger delete"><i class="fa fa-times" aria-hidden="true"></i></button></div></center></td>
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

      //Get les information d'une tache
      if ($_POST["action"] == "Select") {
        $output = array();
        $statement = $connection->prepare(
          "SELECT * FROM attribution 
         WHERE id = '" . $_POST["id"] . "' 
         LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetch();

        $output["heure"] = $result["heure"];

        if ($result["Done"] == null)
          $output["Done"] = "";
        else
          $output["Done"] = date("d-m-Y", strtotime($result["Done"]));

        $output["Label"] = $result["Label"];
        $output["id_Employe"] = $result["id_Employe"];
        $output["id_Projet"] = $result["id_Projet"];

        echo json_encode($output);
      }

      //Mettre a jour une tache
      if ($_POST["action"] == "Update") {

        if ($_POST["Done"] == "undefined-undefined-")
          $_POST["Done"] = null;

        $statement = $connection->prepare(
          "UPDATE attribution
          SET heure = :heure, id_Sprint = :id_Sprint, id_Projet = :id_Projet, Done = :Done, Label = :Label, id_Employe = :id_Employe 
          WHERE id = :id"
        );
        $result = $statement->execute(
          array(
            ':heure' => $_POST["NombreHeure"],
            ':Done' => $_POST["Done"],
            ':Label' => $_POST["Label"],
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
          "DELETE FROM attribution
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