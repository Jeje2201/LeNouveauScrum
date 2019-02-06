   <?php
  session_start();
  require_once('../Modele/Configs.php');

  if (isset($_POST["action"])) {

    //////////////////////////////////// Charger les démos
    if ($_POST["action"] == "LoadDemo") {
      $statement = $connection->prepare("SELECT demo.id as id,
        CONCAT(employe.prenom,' ', employe.initial) as Employe,
        projet.Nom as Projet
        FROM demo
        INNER JOIN projet on projet.id = demo.id_Projet
        INNER JOIN employe on employe.id = demo.id_Employe
        WHERE DateEffectue IS NULL
        ORDER BY id_Employe desc
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
        foreach ($result as $row) {
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
     <td align="center" colspan="10">0 donnée</td>
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
        "DELETE FROM demo WHERE id = :id"
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
