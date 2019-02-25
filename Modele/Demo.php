   <?php
  session_start();
  require_once('../Modele/Configs.php');

  if (isset($_POST["action"])) {

    //////////////////////////////////// Charger les démos
    if ($_POST["action"] == "LoadDemo") {
      $statement = $connection->prepare("SELECT D.id AS id,
        CONCAT(E.prenom,' ', E.initial) AS Employe,
        P.Nom AS Projet
        FROM demo D
        INNER JOIN projet P on P.id = D.id_Projet
        INNER JOIN employe E on E.id = D.id_Employe
        WHERE DateEffectue  IS NULL
        ORDER BY id_Employe DESC
        ");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead class="thead-light">
      <tr>
      <th>Ressource</th>
      <th>Démo</th>';
      if ($_SESSION['TypeUtilisateur'] == 'ScrumMaster')
        $output .= '<th width=""><center>Changer État</center></th>';

      $output .= ' </tr>
      </thead>
      <tbody id="myTable">
      ';
      if ($statement->rowCount() > 0) {
        foreach ($result AS $row) {
          $output .= '
        <tr>
        <td>' . $row["Employe"] . '</td>
        <td>' . $row["Projet"] . '</td>';
          if ($_SESSION['TypeUtilisateur'] == 'ScrumMaster')
            $output .= '
            <td width=10%>
          <center>
          
          <button type="button" id="' . $row["id"] . '" class="btn btn-danger SupprimerDemo"><i class="fa fa-times" aria-hidden="true"></i></button>
          <button type="button" id="' . $row["id"] . '" class="btn btn-success ValiderDemo"><i class="fa fa-check" aria-hidden="true"></i></button>
          </center>
          </td>';
          $output .= '</tr>
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

    //////////////////////////////////// Créer une démo
    if ($_POST["action"] == "CréerDemo") {
      $statement = $connection->prepare("
   INSERT INTO demo (id_Projet, id_Employe) 
   VALUES (:id_Projet, :id_Employe)
   ");
      $result = $statement->execute(
        array(
          ':id_Projet' => $_POST["idProjet"],
          ':id_Employe' => $_POST["idEmploye"]
        )
      );
      if (!empty($result))
        echo '✓';
      else
        print_r($statement->errorInfo());
    }

    //////////////////////////////////// Valider une démo
    if ($_POST["action"] == "ValiderDemo") {
      $statement = $connection->prepare(
      "UPDATE demo 
      SET DateEffectue = NOW()
      WHERE id = :id
      "
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

    //////////////////////////////////// Supprimer une démo
    if ($_POST["action"] == "SupprimerDemo") {
      $statement = $connection->prepare(
        "DELETE FROM demo
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
