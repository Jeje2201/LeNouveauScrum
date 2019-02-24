   <?php
  require_once('../Modele/Configs.php');

  if (isset($_POST["action"])) {

    if ($_POST["action"] == "Load") {
      $statement = $connection->prepare("SELECT P.id,
      P.nom as Projet,
      P.ApiPivotal,
      L.path as Logo,
      T.nom as TypeProjet
      FROM projet P
      INNER JOIN logo L on L.id = P.Id_Logo
      INNER JOIN typeprojet T on T.id = P.id_TypeProjet
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
        <td>' . $row["Projet"] . '</td>
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

    if ($_POST["action"] == "Ajouter") {

      if($_POST["ApiPivotal"] == "")
        $_POST["ApiPivotal"] = NULL;

      $statement = $connection->prepare("
   INSERT INTO projet (nom, Id_Logo, id_TypeProjet, ApiPivotal) 
   VALUES (:Nom, :Id_Logo, :id_TypeProjet, :ApiPivotal)
   ");

      $result = $statement->execute(
        array(
          ':Nom' => $_POST["Nom"],
          ':Id_Logo' => $_POST["fileName"],
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
        $output["Logo"] = $result["Id_Logo"];
        $output["ApiPivotal"] = $result["ApiPivotal"];
        $output["TypeProjet"] = $result["id_TypeProjet"];

      echo json_encode($output);
    }

    if ($_POST["action"] == "Update") {

      if($_POST["ApiPivotal"] == "")
        $_POST["ApiPivotal"] = NULL;

      $statement = $connection->prepare(
        "UPDATE projet 
   SET nom = :nom, Id_Logo = :Id_Logo, id_TypeProjet = :id_TypeProjet, ApiPivotal = :ApiPivotal
   WHERE id = :id
   "
      );
      $result = $statement->execute(
        array(
          ':nom' => $_POST["Nom"],
          ':ApiPivotal' => $_POST["ApiPivotal"],
          ':Id_Logo' => $_POST["fileName"],
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