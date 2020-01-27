   <?php

    session_start();
    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "Load") {
        $idEmploye = $_SESSION['IdUtilisateur'];
        $IdSprint = $_POST["idSprint"];
        $statement = $connection->prepare("SELECT
      (
        select P.nom
        FROM projet P
        WHERE P.id = A.id_Projet
      ) AS projet,
      A.id,
      A.heure,
      A.Label
      FROM tache A
      WHERE id_Employe = $idEmploye
      AND id_sprint = $IdSprint
      AND A.tache_type IS NULL");
        $statement->execute();
        $result = $statement->fetchAll();
        $output = '';
        $output .= '
      <table class="table table-sm table-striped table-bordered" id="datatable" >
      <thead class="thead-light">
      <tr>
      <th>H</th>
      <th>Projet</th>
      <th>Label</th>
      </tr>
      </thead>
      <tbody id="myTable">
      ';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {
            $output .= '
        <tr >
        <td>' . $row["heure"] . '</td>
        <td>' . $row["projet"] . '</td>
        <td><input class="form-control" name="LabelObjectif" onkeypress="ListInputChanged(this)" id="' . $row["id"] . '" type="text" value="' . $row["Label"] . '"></td>
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

      if ($_POST["action"] == "Changer") {

        $TableauLabelObjectuf = $_POST["ToReturn"];

        $statement = $connection->prepare(
          "UPDATE tache 
        SET Label = :Label 
        WHERE id = :id"
        );

        for ($i = 0; $i < count($TableauLabelObjectuf); $i++) {

          $result = $statement->execute(
            array(
              ':id' => $TableauLabelObjectuf[$i][0],
              ':Label' => $TableauLabelObjectuf[$i][1]
            )
          );
        print 'Label "'.$TableauLabelObjectuf[$i][1].'" changé'."\n";
        }
      }
    }

    ?> 