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
      E.nom,
      Pseudo,
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
      <th>Prénom</th>
      <th>Nom</th>
      <th>Initial</th>
      <th>Pseudo</th>
      <th>Job</th>
      <th>ID Pivotal</th>
      <th>Couleur</th>
      <th>Actif</th>
      <th><center>Éditer</center></th>
      </tr>
      </thead>
      <tbody id="myTable">
      ';
      if ($statement->rowCount() > 0) {
        foreach ($result AS $row) {
          $output .= '
        <tr>
        <td>' . $row["prenom"] . '</td>
        <td>' . $row["nom"] . '</td>
        <td>' . $row["Initial"] . '</td>
        <td>' . $row["Pseudo"] . '</td>
        <td>' . $row["TypeJob"] . '</td>
        <td>' . $row["IdPivotal"] . '</td>
        <td style="background-color:' . $row["Couleur"] . '"></td>';

          if ($row["actif"] == 1)
            $output .= '<td style="background-color:#31a031; text-align: center; color: white;    vertical-align: middle;">OUI</td>';
          else
            $output .= '<td style="background-color:#ca3f3f; text-align: center; color: white;    vertical-align: middle;">NON</td>';

          $output .= '<td><center><div class="btn-group" role="group" aria-label="Basic example"><button type="button" id="' . $row["id"] . '" class="btn btn-warning update"><i class="fa fa-pencil" aria-hidden="true"></i></button><button type="button" id="' . $row["id"] . '" class="btn btn-danger delete"><i class="fa fa-times" aria-hidden="true"></i></button></div></center></td>
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

    if ($_POST["action"] == "Ajouter") {

      if($_POST["ApiPivotal"] == "")
        $_POST["ApiPivotal"] = NULL;

      $statement = $connection->prepare("
   INSERT INTO employe (prenom, nom, Pseudo, Couleur, actif, Initial, id_TypeEmploye, mdp, ApiPivotal) 
   VALUES (:prenom, :nom, :pseudo, :Couleur, :actif, :Initial, :Type_Employe, :mdp, :ApiPivotal)
   ");

      $result = $statement->execute(
        array(
          ':prenom' => $_POST["Prenom_Employe"],
          ':pseudo' => $_POST["Prenom_Employe"],
          ':nom' => $_POST["Nom_Employe"],
          ':Couleur' => '#' . random_color(),
          ':actif' => $_POST["Actif"],
          ':Initial' => $_POST["Initial"],
          ':ApiPivotal' => $_POST["ApiPivotal"],
          ':Type_Employe' => $_POST["Type_Employe"],
          ':mdp' => password_hash($_POST["mdp"],PASSWORD_BCRYPT)
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
        "SELECT * FROM employe 
         WHERE id = '" . $_POST["id"] . "' 
         LIMIT 1"
      );
      $statement->execute();
      $result = $statement->fetch();

        $output["Prenom"] = $result["prenom"];
        $output["Nom"] = $result["nom"];
        $output["Actif"] = $result["actif"];
        $output["ApiPivotal"] = $result["ApiPivotal"];
        $output["TypeEmploye"] = $result["id_TypeEmploye"];
        $output["Initial"] = $result["Initial"];

      echo json_encode($output);
    }

    if ($_POST["action"] == "Update") {

      if($_POST["ApiPivotal"] == "")
        $_POST["ApiPivotal"] = NULL;

      $statement = $connection->prepare(
        "UPDATE employe 
   SET prenom = :prenom, nom = :nom, Initial =:Initial, actif = :actif, ApiPivotal = :ApiPivotal, id_TypeEmploye = :Type_Employe
   WHERE id = :id
   "
      );
      $result = $statement->execute(
        array(
          ':prenom' => $_POST["Prenom_Employe"],
          ':nom' => $_POST["Nom_Employe"],
          ':actif' => $_POST["Actif"],
          ':ApiPivotal' => $_POST["ApiPivotal"],
          ':Initial' => $_POST["Initial"],
          ':Type_Employe' => $_POST["Type_Employe"],
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
        "DELETE FROM employe WHERE id = :id"
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
if(password_verify($_POST['ancienmdp'],$result['mdp'])){
  print("JeValide");
    }
  else {
    print('non');
  }

  }
}

  ?>
