   <?php

    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {
      if ($_POST["action"] == "Load") {
        $statement = $connection->prepare("SELECT * FROM sprint
      ORDER BY sprint_numero DESC");
        $statement->execute();
        $result = $statement->fetchAll();
        $output = '';
        $output .= '
    <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
    <thead class="thead-light">
    <tr>
    <th>Numéro</th>
    <th>Début</th>
    <th>Fin</th>
    <th>Attribuable (h)</th>
    <th><center>Éditer</center></th>
    </tr>
    </thead>
    <tbody id="myTable">
    ';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {
            $output .= '
       <tr>
       <td>' . $row["sprint_numero"] . '</td>
       <td>' . date("d/m/Y", strtotime($row["sprint_dateDebut"])) . '</td>
       <td>' . date("d/m/Y", strtotime($row["sprint_dateFin"])) . '</td>
       <td>' . $row["sprint_attribuable"] . '</td>
       <td><center><div class="btn-group" role="group" ><button type="button" id="' . $row["sprint_pk"] . '" class="btn btn-warning btn-sm update"><i class="fa fa-pencil" aria-hidden="true"></i></button><button type="button" id="' . $row["sprint_pk"] . '" class="btn btn-danger btn-sm delete"><i class="fa fa-times" aria-hidden="true"></i></button></div></center></td>
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
        print $output;
      }

      if ($_POST["action"] == "Créer") {
        $statement = $connection->prepare("
   INSERT INTO sprint (sprint_numero, sprint_dateDebut, sprint_dateFin, sprint_attribuable) 
   VALUES (:numero, :dateDebut, :dateFin, :attribuable)
   ");
        $result = $statement->execute(
          array(
            ':numero' => $_POST["numero"],
            ':dateDebut' => $_POST["dateDebut"],
            ':attribuable' => $_POST["Attribuable"],
            ':dateFin' => $_POST["dateFin"]
          )
        );
        if (!empty($result))
          print 'Sprint n°'.$_POST["numero"].' créé';
        else
          print_r($statement->errorInfo());
      }

      if ($_POST["action"] == "SprintMax") {
        $output = '';
        $statement = $connection->prepare(
          "SELECT Max(sprint_numero)+1 AS numero
        FROM sprint"
        );
        $statement->execute();
        $result = $statement->fetch();
        if (isset($result["numero"]))
          print $result["numero"];
        else
          print 1;
      }

      if ($_POST["action"] == "Select") {
        $output = array();
        $statement = $connection->prepare(
          "SELECT * FROM sprint 
        WHERE sprint_pk = '" . $_POST["id"] . "' 
        LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetch();

        print json_encode($result);
      }

      if ($_POST["action"] == "Update") {
        $statement = $connection->prepare(
          "UPDATE sprint 
   SET sprint_numero = :numero, sprint_dateDebut = :dateDebut, sprint_dateFin = :dateFin, sprint_attribuable = :attribuableEdi 
   WHERE sprint_pk = :id
   "
        );
        $result = $statement->execute(
          array(
            ':numero' => $_POST["numero"],
            ':dateDebut' => $_POST["dateDebut"],
            ':dateFin' => $_POST["dateFin"],
            ':attribuableEdi' => $_POST["attribuableEdi"],
            ':id' => $_POST["id"]
          )
        );
        if (!empty($result))
          print 'Sprint n°'.$_POST["numero"].' changé';
        else
          print_r($statement->errorInfo());
      }

      if ($_POST["action"] == "Delete") {
        $statement = $connection->prepare(
          "DELETE FROM sprint
        WHERE sprint_pk = :id"
        );
        $result = $statement->execute(
          array(
            ':id' => $_POST["id"]
          )
        );
        if ($statement->rowCount() > 0)
          print 'Sprint supprimé';
        else
          print_r($statement->errorInfo());
      }
    }

    ?> 