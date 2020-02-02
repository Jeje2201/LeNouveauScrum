   <?php

    session_start();
    require_once('../Modele/Configs.php');

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
      <th>Ressource</th>
      <th>Initial</th>
      <th>Mail</th>
      <th>Job</th>
      <th>ID Pivotal</th>
      <th>Couleur</th>
      <th class="centered">Actif</th>
      <th class="centered">Fiche de temps</th>
      <th class="centered">Admin</th>
      <th><center>Éditer</center></th>
      </tr>
      </thead>
      <tbody id="myTable">
      ';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {
            $output .= '
              <tr>
              <td>' . $row["user_prenom"] . ' '. $row["user_nom"] .'</td>
              <td>' . $row["user_initial"] . '</td>
              <td>' . $row["user_mail"] . '</td>
              <td>' . $row["user_type"] . '</td>
              <td>' . $row["user_apiPivotal"] . '</td>
              <td style="background-color:' . $row["user_couleur"] . '"></td>';

            if ($row["user_actif"])
              $output .= '<td class="centered text-white bg-success">Actif</td>';
            else
              $output .= '<td class="centered text-white bg-danger">Absents</td>';

            if ($row["user_mailCir"])
              $output .= '<td class="centered text-white bg-success">Mail</td>';
            else
            $output .= '<td class="centered text-white bg-danger">Rien</td>';

            if ($row["user_admin"])
              $output .= '<td class="centered text-white bg-success">Admin</td>';
            else
              $output .= '<td class="centered text-white bg-danger">Lambda</td>';

            $output .= '<td><center><div class="btn-group" role="group" ><button type="button" id="' . $row["user_pk"] . '" class="btn btn-warning update"><i class="fa fa-pencil" aria-hidden="true"></i></button><button type="button" id="' . $row["user_pk"] . '" class="btn btn-danger delete"><i class="fa fa-times" aria-hidden="true"></i></button><button type="button" id="' . $row["user_pk"] . '" class="btn btn-dark password"><i class="fa fa-key" aria-hidden="true"></i></button></div></center></td>
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

      //Créer une ressource
      if ($_POST["action"] == "Ajouter") {

        if ($_POST["ApiPivotal"] == "")
          $_POST["ApiPivotal"] = 0;

        $statement = $connection->prepare(
          "INSERT INTO user (user_prenom, user_nom, user_couleur, user_actif, user_mailCir, user_admin, user_initial, user_type, user_mdp, user_apiPivotal, user_registerDate, user_mail) 
          VALUES (:prenom, :nom, :Couleur, :actif, :MailCir, :admin, :Initial, :Type_Employe, :mdp, :ApiPivotal, :RegisterDate, :mail)
        ");

        $result = $statement->execute(
          array(
            ':prenom' => $_POST["Prenom_Employe"],
            ':nom' => $_POST["Nom_Employe"],
            ':Couleur' => '#000000',
            ':actif' => $_POST["Actif"],
            ':MailCir' => $_POST["MailCir"],
            ':admin' => $_POST["admin"],
            ':RegisterDate' => date("Y-m-d", strtotime($_POST["RegisterDate"])),
            ':Initial' => $_POST["Initial"],
            ':ApiPivotal' => $_POST["ApiPivotal"],
            ':Type_Employe' => $_POST["Type_Employe"],
            ':mdp' => password_hash('123naturalsolutions456', PASSWORD_BCRYPT),
            ':mail' => $_POST["Email"]
          )
        );
        if (!empty($result))
          print 'Ressource "'.$_POST["Prenom_Employe"]. ' ' .$_POST["Nom_Employe"] .'" créée';
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
          SET user_prenom = :prenom, user_nom = :nom, user_initial =:Initial, user_actif = :actif, user_mailCir = :MailCir, user_admin = :admin, user_apiPivotal = :ApiPivotal, user_type = :Type_Employe, user_registerDate = :RegisterDate, user_mail = :mail
          WHERE user_pk = :id"
        );
        $result = $statement->execute(
          array(
            ':prenom' => $_POST["Prenom_Employe"],
            ':nom' => $_POST["Nom_Employe"],
            ':actif' => $_POST["Actif"],
            ':MailCir' => $_POST["MailCir"],
            ':admin' => $_POST["admin"],
            ':RegisterDate' => date("Y-m-d", strtotime($_POST["RegisterDate"])),
            ':ApiPivotal' => $_POST["ApiPivotal"],
            ':Initial' => $_POST["Initial"],
            ':Type_Employe' => $_POST["Type_Employe"],
            ':mail' => $_POST["Email"],
            ':id' => $_POST["id"]
          )
        );
        if (!empty($result))
          print 'Ressource "' .$_POST["Prenom_Employe"].' '. $_POST["Nom_Employe"] .'" changée';
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
          print 'Ressource supprimée';
        else
          print_r($statement->errorInfo());
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
          print 'Nouveau mot de passe créé';
        else
          print_r($statement->errorInfo());
      }

      if ($_POST["action"] == "ChangerAvatar") {

        $target_file = basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $target_file = 'avatar_user_'. $_SESSION['user']['id'] . '.'.$imageFileType;
        $pathDeLimage= "../Assets/Image/Ressources/" . $target_file;

        if (file_exists($target_file)) {
          print "Ce nom d'image existe déjà. Changez le nom et recommencez.";
        }

        else if ($_FILES["image"]["size"] > 2000000) {
          print "Tu veux pas envoyer un fichier de la taille d'un film aussi ? Trouve plus petit (max = 2mo)";
        }

        else if (move_uploaded_file($_FILES["image"]["tmp_name"], $pathDeLimage)) {

          $statement = $connection->prepare(
            $sql = "SELECT user_avatar
            FROM user
            WHERE user_pk = " . $_SESSION['user']['id']
          );
  
          $statement->execute();
          $result = $statement->fetch();

          if($result[0] != null){
            if (unlink("../Assets/Image/Ressources/".$result[0])) {
              print "Suppression du précédent avatar réussi\n";
            } else {
               print "Impossible de supprimer l'image précédente ".$result[0]."\n";
            }
         }else{
            print "Aucune image précédente.\n";
         }

          $statement = $connection->prepare(
            $sql = "UPDATE user
            set user_avatar = '". $target_file ."'
            WHERE user_pk = " . $_SESSION['user']['id']
          );
  
          $statement->execute();

          move_uploaded_file($_FILES["image"]["tmp_name"], $pathDeLimage);

          print "Votre avatar a évolué ! Félicitation !";

        }
        else{
          print "Une erreur est survenu mais non reconnue.. L'image dépasse peut être 2mo ?";
        }
      }

      if ($_POST["action"] == "isAdmin") {
        
        $output = array();
        $statement = $connection->prepare(
          "SELECT * FROM user 
         WHERE user_pk = '" . $_SESSION['user']['id'] . "' 
         LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetch();

        $output["Admin"] = $result["user_admin"];

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