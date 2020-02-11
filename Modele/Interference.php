   <?php

    session_start();
    require_once('Configs.php');

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "Load") {
        $numero = $_POST["idAffiche"];
        $statement = $connection->prepare("SELECT *
      FROM interference
      INNER join user ON interference_fk_user = user_pk
      INNER JOIN projet ON interference_fk_projet = projet_pk
      WHERE interference_fk_sprint = $numero
      ORDER BY user_prenom, interference_fk_projet asc");
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
        <td>' . $row["interference_heure"] . '</td>
        <td>' . $row["user_prenom"] . ' ' . $row["user_nom"] . '</td>
        <td>' . $row["projet_nom"] . '</td>
        <td>' . $row["interference_type"] . '</td>
        <td>' . $row["interference_label"] . '</td>';


        if($row["user_pk"] == $_SESSION['user']['id']){

          $output .='<td><center><div class="btn-group" role="group" ><button type="button" id="' . $row["interference_pk"] . '" class="btn btn-warning update"><i class="fa fa-pencil" aria-hidden="true"></i></button><button type="button" id="' . $row["interference_pk"] . '" class="btn btn-danger delete"><i class="fa fa-trash" aria-hidden="true"></i></button></div></center></td>
        </tr>';
        }
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
   INSERT INTO interference (interference_heure, interference_type, interference_fk_sprint, interference_fk_projet, interference_fk_user, interference_label) 
   VALUES (:heure, :typeinterference, :sprint, :projet, :employe, :label)
   ");

        $result = $statement->execute(
          array(
            ':heure' => $_POST["NbHeure"],
            ':typeinterference' => $_POST["TypeInterferance"],
            ':sprint' => $_POST["idAffichee"],
            ':projet' => $_POST["Projet"],
            ':label' => $_POST["labelinterference"],
            ':employe' => $_SESSION['user']['id']
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
        WHERE interference_pk = '" . $_POST["id"] . "' 
        LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetch();

        $output["Heure"] = $result["interference_heure"];
        $output["TypeInterferance"] = $result["interference_type"];
        $output["Sprint"] = $result["interference_fk_sprint"];
        $output["Projet"] = $result["interference_fk_projet"];
        $output["Employe"] = $result["interference_fk_user"];
        $output["labelinterference"] = $result["interference_label"];

        print json_encode($output);
      }

      if ($_POST["action"] == "Update") {
        $statement = $connection->prepare(
          "UPDATE interference 
   SET interference_heure = :heure, interference_type = :typeinterference, interference_fk_sprint =:sprint, interference_fk_projet = :projet, interference_fk_user = :employe, interference_label = :label
   WHERE interference_pk = :id"
        );
        $result = $statement->execute(
          array(
            ':heure' => $_POST["NbHeure"],
            ':typeinterference' => $_POST["TypeInterferance"],
            ':sprint' => $_POST["idAffichee"],
            ':projet' => $_POST["Projet"],
            ':employe' => $_SESSION['user']['id'],
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
        WHERE interference_pk = :id"
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