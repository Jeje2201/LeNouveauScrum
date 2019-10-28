   <?php

    function random_color_part()
    {
      return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    function random_color()
    {
      return random_color_part() . random_color_part() . random_color_part();
    }

    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "Load") {
        $statement = $connection->prepare("SELECT E.id,
      E.prenom,
      E.Initial,
      E.mail,
      E.RegisterDate,
      E.nom,
      E.admin,
      E.MailCir,
      E.actif,
      (
        select T.nom
        FROM typeemploye T
        WHERE T.id = E.id_TypeEmploye
        ) AS TypeJob,
        ApiPivotal AS IdPivotal,
        E.Couleur AS Couleur
        FROM employe E
        ORDER BY E.prenom asc");
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
      <th class="centered">Mail</th>
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
              <td>' . $row["prenom"] . ' '. $row["nom"] .'</td>
              <td>' . $row["Initial"] . '</td>
              <td>' . $row["mail"] . '</td>
              <td>' . $row["TypeJob"] . '</td>
              <td>' . $row["IdPivotal"] . '</td>
              <td style="background-color:' . $row["Couleur"] . '"></td>';

            if ($row["actif"])
              $output .= '<td class="centered bg-success"></td>';
            else
              $output .= '<td class="centered bg-danger"></td>';

            if ($row["MailCir"])
              $output .= '<td class="centered bg-success"></td>';
            else
            $output .= '<td class="centered bg-danger"></td>';

            if ($row["admin"])
              $output .= '<td class="centered bg-success"></td>';
            else
              $output .= '<td class="centered bg-danger"></td>';

            $output .= '<td><center><div class="btn-group" role="group" ><button type="button" id="' . $row["id"] . '" class="btn btn-warning update"><i class="fa fa-pencil" aria-hidden="true"></i></button><button type="button" id="' . $row["id"] . '" class="btn btn-danger delete"><i class="fa fa-times" aria-hidden="true"></i></button></div></center></td>
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

      //Créer une ressource
      if ($_POST["action"] == "Ajouter") {

        if ($_POST["ApiPivotal"] == "")
          $_POST["ApiPivotal"] = 0;

        $statement = $connection->prepare(
          "INSERT INTO employe (prenom, nom, Couleur, actif, MailCir, admin, Initial, id_TypeEmploye, mdp, ApiPivotal, RegisterDate, mail) 
          VALUES (:prenom, :nom, :Couleur, :actif, :MailCir, :admin, :Initial, :Type_Employe, :mdp, :ApiPivotal, :RegisterDate, :mail)
        ");

        $result = $statement->execute(
          array(
            ':prenom' => $_POST["Prenom_Employe"],
            ':nom' => $_POST["Nom_Employe"],
            ':Couleur' => '#' . random_color(),
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
          echo 'Ressource "'.$_POST["Prenom_Employe"]. ' ' .$_POST["Nom_Employe"] .'" créée';
        else
          print_r($statement->errorInfo());
      }

      if ($_POST["action"] == "Select") {
        $output = array();
        $statement = $connection->prepare(
          "SELECT * FROM employe 
         WHERE id = '" . $_POST["id"] . "' 
         LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetch();

        $output["Prenom"] = $result["prenom"];
        $output["Nom"] = $result["nom"];
        $output["Actif"] = $result["actif"];
        $output["MailCir"] = $result["MailCir"];
        $output["admin"] = $result["admin"];
        $output["Mail"] = $result["mail"];
        $output["ApiPivotal"] = $result["ApiPivotal"];
        $output["TypeEmploye"] = $result["id_TypeEmploye"];
        $output["RegisterDate"] = date("d-m-Y", strtotime($result["RegisterDate"]));
        $output["Initial"] = $result["Initial"];

        echo json_encode($output);
      }

      //Update employe
      if ($_POST["action"] == "Update") {

        if ($_POST["ApiPivotal"] == "")
          $_POST["ApiPivotal"] = null;

        $statement = $connection->prepare(
          "UPDATE employe 
          SET prenom = :prenom, nom = :nom, Initial =:Initial, actif = :actif, MailCir = :MailCir, admin = :admin, ApiPivotal = :ApiPivotal, id_TypeEmploye = :Type_Employe, RegisterDate = :RegisterDate, mail = :mail
          WHERE id = :id"
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
          echo 'Ressource "' .$_POST["Prenom_Employe"].' '. $_POST["Nom_Employe"] .'" changée';
        else
          print_r($statement->errorInfo());
      }

      //Delete un employe
      if ($_POST["action"] == "Delete") {
        $statement = $connection->prepare(
          "DELETE FROM employe WHERE id = :id"
        );
        $result = $statement->execute(
          array(
            ':id' => $_POST["id"]
          )
        );
        if (!empty($result))
          echo 'Ressource supprimée';
        else
          print_r($statement->errorInfo());
      }

      //fonction utilisée dans la page spécialisé au mdps
      if ($_POST["action"] == "Checkpswd") {

        //Recuperer le mdp chiffré du user qui essaie de se connecter
        $statement = $connection->prepare(
          $sql = "SELECT E.mdp AS mdp
          FROM employe E
          WHERE E.id = " . $_POST["idRessource"]
        );

        $statement->execute();
        $result = $statement->fetch();

        //Checker si le mdp rentré est le meme que celui de ce user chiffré dans la bdd et le renvoyé sur l'index avec ou sans message d'erreur
        if (password_verify($_POST['ancienmdp'], $result['mdp'])) {
          print("JeValide");
        } else {
          print('non');
        }
      }
    }

    ?> 