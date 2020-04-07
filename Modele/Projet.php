   <?php
    require_once('Configs.php');

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "Load") {
        $statement = $connection->prepare("SELECT * FROM projet
      ORDER BY projet_actif desc, projet_nom asc");
        $statement->execute();
        $result = $statement->fetchAll();
        $output = '';
        $output .= '
      <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead class="thead-light">
      <tr>
      <th width=35>Icone</th>
      <th>Nom</th>
      <th>Type</th>
      <th>ID Pivotal</th>
      <th class="text-center">Actif</th>
      <th class="text-center">Action</th>
      </tr>
      </thead>
      <tbody id="myTable">
      ';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {

            if (file_exists("../Assets/Image/Projets/avatar_projet_" . $row["projet_pk"] .".png")) {
              $row["projet_avatar"] = "avatar_projet_" . $row["projet_pk"] .".png";
            }else{
              $row["projet_avatar"] = "default.png";
            }

        $output .= '
        <td class="text-center" ><img src="Assets/Image/Projets/' . $row['projet_avatar'] . '" alt="' . $row['projet_avatar'] . '" width="35px" height="35px"/></td>
        <td>' . $row["projet_nom"] . '</td>
        <td>' . $row["projet_type"] . '</td>
        <td>' . $row["projet_apiPivotal"] . '</td>';
            if ($row["projet_actif"] == 2)
              $output .= '<td class="bg-success text-center text-white">En cours</td>';
            else if ($row["projet_actif"] == 1)
              $output .= '<td class="bg-warning text-center text-white">CIR</td>';
            else
              $output .= '<td class="bg-danger text-center text-white">Terminé</td>';
            $output .= '<td>
            <div class="btn-group d-flex" role="group" >
              <button  id="' . $row["projet_pk"] . '" class="btn btn-warning update"><i class="fa fa-pencil" aria-hidden="true"></i></button>
              <button  id="' . $row["projet_pk"] . '" class="btn btn-danger delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
              <button  id="' . $row["projet_pk"] . '" class="btn btn-info projectInfo"><i class="fa fa-info" aria-hidden="true"></i></button>
              <button  id="'. $row["projet_pk"] . '" class="btn btn-dark projectLogo"><i class="fa fa-file-image-o" aria-hidden="true"></i></button>
            </div></td>
      </tr>';
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

        if ($_POST["ApiPivotal"] == "")
          $_POST["ApiPivotal"] = null;

        $statement = $connection->prepare("
   INSERT INTO projet (projet_nom, projet_actif, projet_type, projet_apiPivotal) 
   VALUES (:Nom, :actif, :id_TypeProjet, :ApiPivotal)
   ");

        $result = $statement->execute(
          array(
            ':Nom' => $_POST["Nom"],
            ':actif' => $_POST["Actif"],
            ':id_TypeProjet' => $_POST["TypeProjet"],
            ':ApiPivotal' => $_POST["ApiPivotal"]
          )
        );
        if (!empty($result))
          print true;
        else
          print_r($statement->errorInfo());
      }

      if ($_POST["action"] == "Select") {
        $output = array();
        $statement = $connection->prepare(
          "SELECT * FROM projet 
         WHERE projet_pk = '" . $_POST["id"] . "' 
         LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetch();

        print json_encode($result);
      }

      if ($_POST["action"] == "Update") {

        if ($_POST["ApiPivotal"] == "")
          $_POST["ApiPivotal"] = null;

        $statement = $connection->prepare(
          "UPDATE projet 
          SET projet_nom = :nom,
          projet_type = :id_TypeProjet,
          projet_actif = :actif,
          projet_apiPivotal = :ApiPivotal,
          projet_description = :PDescription
          WHERE projet_pk = :id
          "
        );
        $result = $statement->execute(
          array(
            ':nom' => $_POST["Nom"],
            ':ApiPivotal' => $_POST["ApiPivotal"],
            ':actif' => $_POST["Actif"],
            ':id_TypeProjet' => $_POST["TypeProjet"],
            ':PDescription' => $_POST["PDescription"],
            ':id' => $_POST["id"]
          )
        );
        if (!empty($result))
          print true;
        else
          print_r($statement->errorInfo());
      }

      if ($_POST["action"] == "Delete") {
        $statement = $connection->prepare(
          "DELETE FROM projet
         WHERE projet_pk = :id"
        );
        $result = $statement->execute(
          array(
            ':id' => $_POST["id"]
          )
        );
        if ($statement->rowCount() > 0)
          print true;
        else
          print_r($statement->errorInfo());

        if (file_exists("../Assets/Image/Projets/avatar_projet_" . $_POST["id"] .".png")) {
          unlink("../Assets/Image/Projets/avatar_projet_" . $_POST["id"] .".png");
          print "Une image pour ce projet existait déjà, elle est supprimée.\n";
        }
      }

      if ($_POST["action"] == "Projet_Changer_Avatar") {
        $imageFileType = strtolower(pathinfo(basename($_FILES["image"]["name"]), PATHINFO_EXTENSION));
        $pathDeLimage= '../Assets/Image/Projets/avatar_projet_'. $_POST["logo_project_id"] . '.png';

        if($imageFileType == "png"){
          if (file_exists($pathDeLimage)) {
            unlink($pathDeLimage);
            print "Une image pour ce logo existait déjà, elle est supprimée.\n";
          }
          else{
            print "Aucune image connu pour se logo.\n";
          }

          move_uploaded_file($_FILES["image"]["tmp_name"], $pathDeLimage);

          print "Nouveau logo créé avec succès.";

        }
        else{
          print "L'image doit être un png.";
        }
      }

    }

    ?> 