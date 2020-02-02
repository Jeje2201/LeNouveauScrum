   <?php

    session_start();
    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "Load") {
        $idEmploye = $_SESSION['user']['id'];
        $IdSprint = $_POST["idSprint"];
        $statement = $connection->prepare(
        "SELECT *
        FROM tache
        inner join projet on tache_fk_projet = projet_pk
        WHERE tache_fk_user = $idEmploye
        AND tache_fk_sprint = $IdSprint");
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
        <td>' . $row["tache_heure"] . '</td>
        <td>' . $row["projet_nom"] . '</td>
        <td><input class="form-control" name="LabelObjectif" onkeypress="ListInputChanged(this)" id="' . $row["tache_pk"] . '" type="text" value="' . $row["tache_label"] . '"></td>
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
        SET tache_label = :Label 
        WHERE tache_pk = :id"
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