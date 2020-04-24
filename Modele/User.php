   <?php

    session_start();
    require_once('Configs.php');

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "Load") {
        $statement = $connection->prepare("SELECT *
      FROM user
      ORDER BY user_prenom asc");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead class="thead-light">
      <tr>
      <th class="text-center">Avatar</th>
      <th>Ressource</th>
      <th>Job</th>
      <th class="text-center">Actif</th>
      <th class="text-center">Planification</th>
      <th class="text-center">Fiche de temps</th>
      <th class="text-center">Admin</th>
      <th class="text-center">Action</th>
      </tr>
      </thead>
      <tbody id="myTable">
      ';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {

            if (file_exists("../Assets/Image/Ressources/avatar_user_" . $row["user_pk"] .".png")) {
              $row["user_avatar"] = "avatar_user_" . $row["user_pk"] .".png";
            }else{
              $row["user_avatar"] = "default.png";
            }

            $output .= '
              <tr>
              <td class="text-center"><img src="Assets/Image/Ressources/'. $row["user_avatar"] .'" alt="'. $row["user_avatar"] .'" width="45px" height="45px"></td>
              <td>' . $row["user_prenom"] . ' '. $row["user_nom"] .'</td>
              <td>' . $row["user_type"] . '</td>';

            if ($row["user_actif"])
              $output .= '<td class="text-center text-white" style="background-color: #4a8a58">Actif</td>';
            else
              $output .= '<td class="text-center text-white" style="background-color: #b5424d">Absents</td>';

            if ($row["user_doesPlanification"])
              $output .= '<td class="text-center text-white" style="background-color: #4a8a58">Planif</td>';
            else
              $output .= '<td class="text-center text-white" style="background-color: #b5424d">Repos</td>';

            if ($row["user_mailCir"])
              $output .= '<td class="text-center text-white" style="background-color: #4a8a58">Mail</td>';
            else
            $output .= '<td class="text-center text-white" style="background-color: #b5424d">Rien</td>';

            if ($row["user_admin"])
              $output .= '<td class="text-center text-white" style="background-color: #4a8a58">Admin</td>';
            else
              $output .= '<td class="text-center text-white" style="background-color: #b5424d">Lambda</td>';

            $output .= '<td>
            <div class="btn-group d-flex" role="group" >
              <button  id="' . $row["user_pk"] . '" class="btn btn-warning update"><i class="fa fa-pencil" aria-hidden="true"></i></button>
              <button  id="' . $row["user_pk"] . '" class="btn btn-danger delete"><i class="fa fa-trash" aria-hidden="true"></i></button>
              <button  id="' . $row["user_pk"] . '" class="btn btn-dark password"><i class="fa fa-key" aria-hidden="true"></i></button>
              <button  id="avatar_' . $row["user_pk"] . '" class="btn btn-primary avatar_user"><i class="fa fa-file-image-o" aria-hidden="true"></i></button>
            </div></td>
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

      //Liste une ressource
      if ($_POST["action"] == "GetUsers") {
        $statement = $connection->prepare("SELECT *
        FROM user
        ORDER BY user_prenom asc");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);

      };

      //Créer une ressource
      if ($_POST["action"] == "Ajouter") {

        if ($_POST["ApiPivotal"] == "")
          $_POST["ApiPivotal"] = 0;

        $statement = $connection->prepare(
          "INSERT INTO user (user_prenom, user_nom, user_actif, user_mailCir, user_admin, user_doesPlanification, user_initial, user_type, user_mdp, user_apiPivotal, user_registerDate, user_mail) 
          VALUES (:prenom, :nom, :actif, :MailCir, :admin, :user_doesPlanification, :Initial, :Type_Employe, :mdp, :ApiPivotal, :RegisterDate, :mail)
        ");

        $result = $statement->execute(
          array(
            ':prenom' => $_POST["Prenom_Employe"],
            ':nom' => $_POST["Nom_Employe"],
            ':actif' => $_POST["Actif"],
            ':MailCir' => $_POST["MailCir"],
            ':admin' => $_POST["admin"],
            ':user_doesPlanification' => $_POST["doesPlanification"],
            ':RegisterDate' => date("Y-m-d", strtotime($_POST["RegisterDate"])),
            ':Initial' => $_POST["Initial"],
            ':ApiPivotal' => $_POST["ApiPivotal"],
            ':Type_Employe' => $_POST["Type_Employe"],
            ':mdp' => password_hash('123naturalsolutions456', PASSWORD_BCRYPT),
            ':mail' => $_POST["Email"]
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
          "SELECT * FROM user 
         WHERE user_pk = '" . $_POST["id"] . "' 
         LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetch();

        $output["Prenom"] = $result["user_prenom"];
        $output["Nom"] = $result["user_nom"];
        $output["Actif"] = $result["user_actif"];
        $output["MailCir"] = $result["user_mailCir"];
        $output["admin"] = $result["user_admin"];
        $output["Mail"] = $result["user_mail"];
        $output["doesPlanification"] = $result["user_doesPlanification"];
        $output["ApiPivotal"] = $result["user_apiPivotal"];
        $output["TypeEmploye"] = $result["user_type"];
        $output["RegisterDate"] = date("d-m-Y", strtotime($result["user_registerDate"]));
        $output["Initial"] = $result["user_initial"];

        print json_encode($output);
      }

      //Update employe
      if ($_POST["action"] == "Update") {

        if ($_POST["ApiPivotal"] == "")
          $_POST["ApiPivotal"] = 0;

        $statement = $connection->prepare(
          "UPDATE user 
          SET user_prenom = :prenom, user_nom = :nom, user_initial =:Initial, user_actif = :actif, user_mailCir = :MailCir, user_admin = :admin, user_doesPlanification = :doesPlanification, user_apiPivotal = :ApiPivotal, user_type = :Type_Employe, user_registerDate = :RegisterDate, user_mail = :mail
          WHERE user_pk = :id"
        );
        $result = $statement->execute(
          array(
            ':prenom' => $_POST["Prenom_Employe"],
            ':nom' => $_POST["Nom_Employe"],
            ':actif' => $_POST["Actif"],
            ':MailCir' => $_POST["MailCir"],
            ':admin' => $_POST["admin"],
            ':doesPlanification' => $_POST["doesPlanification"],
            ':RegisterDate' => date("Y-m-d", strtotime($_POST["RegisterDate"])),
            ':ApiPivotal' => $_POST["ApiPivotal"],
            ':Initial' => $_POST["Initial"],
            ':Type_Employe' => $_POST["Type_Employe"],
            ':mail' => $_POST["Email"],
            ':id' => $_POST["id"]
          )
        );
        if (!empty($result))
          print true;
        else
          print_r($statement->errorInfo());
      }

      //Delete un employe
      if ($_POST["action"] == "Delete") {
        $statement = $connection->prepare(
          "DELETE FROM user WHERE user_pk = :id"
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

          if (file_exists("../Assets/Image/Ressources/avatar_user_" . $_POST["id"] .".png")) {
            unlink("../Assets/Image/Ressources/avatar_user_" . $_POST["id"] .".png");
            print "Une image pour ce user existait déjà, elle est supprimée.\n";
          }
      }

      //fonction utilisée dans la page spécialisé au mdps
      if ($_POST["action"] == "Checkpswd") {

        //Recuperer le mdp chiffré du user qui essaie de se connecter
        $statement = $connection->prepare(
          $sql = "SELECT user_mdp
          FROM user
          WHERE user_pk = " . $_SESSION['user']['id']
        );

        $statement->execute();
        $result = $statement->fetch();

        //Checker si le mdp rentré est le meme que celui de ce user chiffré dans la bdd et le renvoyé sur l'index avec ou sans message d'erreur
        if (password_verify($_POST['ancienmdp'], $result['user_mdp'])) {
          print("JeValide");
        } else {
          print('non');
        }
      }

      if ($_POST["action"] == "UpdateMdpBasic") {
        $statement = $connection->prepare(
          "UPDATE user 
        SET user_mdp = :mdp
        WHERE user_pk = :id"
        );
        $result = $statement->execute(
          array(
            ':mdp' => password_hash($_POST["mdp"], PASSWORD_BCRYPT),
            ':id' => $_SESSION['user']['id']
          )
        );
        if (!empty($result))
          print true;
        else
          print_r($statement->errorInfo());
      }

      if ($_POST["action"] == "User_Changer_Avatar") {
        $imageFileType = strtolower(pathinfo(basename($_FILES["image"]["name"]), PATHINFO_EXTENSION));
        $pathDeLimage= '../Assets/Image/Ressources/avatar_user_'. $_POST["user_avatar_id"] . '.png';

        if($imageFileType == "png"){
          if (file_exists($pathDeLimage)) {
            unlink($pathDeLimage);
            print "Une image pour ce compte existait déjà, elle est supprimée.\n";
          }
          else{
            print "Aucune image connu pour se compte connu.\n";
          }

          move_uploaded_file($_FILES["image"]["tmp_name"], $pathDeLimage);

          print "Nouvel avatar créé avec succès.";

        }
        else{
          print "L'image doit être un png.";
        }
      }

      if ($_POST["action"] == "isAdmin") {

        if(isset($_SESSION['user']['id'])){
        
        $output = array();
        $statement = $connection->prepare(
          "SELECT * FROM user 
         WHERE user_pk = '" . $_SESSION['user']['id'] . "' 
         LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetch();

        $output["Admin"] = $result["user_admin"];
      }else{
        $output["Admin"] = 0;
      }

        print json_encode($output);
      }

      if ($_POST["action"] == "setMdpOp") {
        $statement = $connection->prepare(
          "UPDATE user 
        SET user_mdp = :mdp
        WHERE user_pk = :id"
        );
        $result = $statement->execute(
          array(
            ':mdp' => password_hash($_POST["mdp"], PASSWORD_BCRYPT),
            ':id' => $_POST["idRessource"]
          )
        );
        if (!empty($result))
          print true;
        else
          print_r($statement->errorInfo());
      }
    }

    ?> 