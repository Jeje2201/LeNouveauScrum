   <?php

    session_start();
    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "Load") {
        $numero = $_POST["idAffiche"];
        $statement = $connection->prepare("SELECT I.id,
      I.heure,
      I.label,
      CONCAT(E.prenom,'&nbsp;', E.initial) AS Employe,
      projet.nom,
      I.interference_type AS TypeInterference
      FROM interference I
      INNER join employe E
        ON E.id = I.id_Employe
      INNER JOIN projet
        ON projet.id = I.id_Projet
      WHERE I.id_Sprint = $numero
      ORDER BY E.prenom, I.id_Projet asc");
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
        <td>' . $row["heure"] . '</td>
        <td>' . $row["Employe"] . '</td>
        <td>' . $row["nom"] . '</td>
        <td>' . $row["TypeInterference"] . '</td>
        <td>' . $row["label"] . '</td>
        <td><center><div class="btn-group" role="group" ><button type="button" id="' . $row["id"] . '" class="btn btn-warning update"><i class="fa fa-pencil" aria-hidden="true"></i></button><button type="button" id="' . $row["id"] . '" class="btn btn-danger delete"><i class="fa fa-times" aria-hidden="true"></i></button></div></center></td>
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

      if ($_POST["action"] == "Ajouter") {
        $statement = $connection->prepare("
   INSERT INTO interference (heure, interference_type, id_Sprint, id_Projet, id_Employe, label) 
   VALUES (:heure, :typeinterference, :sprint, :projet, :employe, :label)
   ");

        $result = $statement->execute(
          array(
            ':heure' => $_POST["NbHeure"],
            ':typeinterference' => $_POST["TypeInterferance"],
            ':sprint' => $_POST["idAffichee"],
            ':projet' => $_POST["Projet"],
            ':label' => $_POST["labelinterference"],
            ':employe' => $_SESSION['IdUtilisateur']
          )
        );
        if (!empty($result))
          print 'Interférence "'.$_POST["labelinterference"].'" créée';
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
        $result = $statement->fetch();

        $output["Heure"] = $result["heure"];
        $output["TypeInterferance"] = $result["interference_type"];
        $output["Sprint"] = $result["id_Sprint"];
        $output["Projet"] = $result["id_Projet"];
        $output["Employe"] = $result["id_Employe"];
        $output["labelinterference"] = $result["label"];

        print json_encode($output);
      }

      if ($_POST["action"] == "Update") {
        $statement = $connection->prepare(
          "UPDATE interference 
   SET heure = :heure, interference_type = :typeinterference, id_Sprint =:sprint, id_Projet = :projet, id_Employe = :employe, label = :label
   WHERE id = :id
   "
        );
        $result = $statement->execute(
          array(
            ':heure' => $_POST["NbHeure"],
            ':typeinterference' => $_POST["TypeInterferance"],
            ':sprint' => $_POST["idAffichee"],
            ':projet' => $_POST["Projet"],
            ':employe' => $_SESSION['IdUtilisateur'],
            ':label' => $_POST["labelinterference"],
            ':id' => $_POST["id"]
          )
        );
        if (!empty($result))
          print 'Interférence "'.$_POST["labelinterference"].'" changée';
        else
          print_r($statement->errorInfo());
      }

      if ($_POST["action"] == "Delete") {
        $statement = $connection->prepare(
          "DELETE FROM interference
        WHERE id = :id"
        );
        $result = $statement->execute(
          array(
            ':id' => $_POST["id"]
          )
        );
        if ($statement->rowCount() > 0)
          print 'Interférence supprimée';
        else
          print_r($statement->errorInfo());
      }
    }

    ?> 