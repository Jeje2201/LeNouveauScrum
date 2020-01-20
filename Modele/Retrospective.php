   <?php
    session_start();
    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "LoadObjectif") {
        $numero = $_POST["idAffiche"];
        $statement = $connection->prepare("SELECT O.id,
        O.objectif,
        S.couleur,
        P.nom AS projet,
        CONCAT(employe.prenom,'&nbsp;', employe.initial) AS Employe,
        S.nom AS etat
        FROM objectif O
        INNER JOIN statutobjectif S
          ON S.id = O.id_StatutObjectif
        INNER JOIN projet P
          ON P.id = O.id_Projet
        INNER JOIN employe
          ON employe.id = O.id_Employe
        WHERE O.id_Sprint = $numero
        ORDER BY Employe, P.nom, O.id");
          $statement->execute();
          $result = $statement->fetchAll();
          $output = '';
          $output .= '
        <table class="table table-sm table-striped table-bordered" id="datatable" >
        <thead class="thead-light">
        <tr>
        <th>N°</th>
        <th>État</th>
        <th>Ressource</th>
        <th>Projet</th>
        <th>Objectif</th>';

      
        if ($_SESSION['Admin'])
          $output .= '<th colspan="2"><center>Changer État</center></th>';
        $output .= '
        </tr>
        </thead>
        <tbody id="myTable">
        ';
          if ($statement->rowCount() > 0) {
            $num = 0;
            foreach ($result as $row) {
              $num += 1;
              $output .= '
          <tr >
          
          <td>' . $num . '</td>
          <td class="centered font-weight-bold text-white" style="background-color: ' . $row["couleur"] . ';">' . $row["etat"] . '</td>
          <td>' . $row["Employe"] . '</td>
          <td>' . $row["projet"] . '</td>
          <td>' . $row["objectif"] . '</td>';
              if ($_SESSION['Admin'])
                $output .= '
          <td><center><div class="btn-group" role="group" >
          <button type="button" id="' . $row["id"] . '" class="btn btn-success 1"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button>
          <button type="button" id="' . $row["id"] . '" class="btn btn-warning 2"><i class="fa fa-hourglass-half" aria-hidden="true"></i></button>
          <button type="button" id="' . $row["id"] . '" class="btn btn-danger 3"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button>
          <button type="button" id="' . $row["id"] . '" class="btn btn-dark 4"><i class="fa fa-times" aria-hidden="true"></i></button>
          <button type="button" id="' . $row["id"] . '" class="btn btn-primary 5"><i class="fa fa-question" aria-hidden="true"></i></button>
          </div></center></td>
          
          <td>
          <center>
          <button type="button" id="' . $row["id"] . '" class="btn btn-warning GetObjectif"><i class="fa fa-pencil" aria-hidden="true"></i></button>
          </center>
          </td>
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

      
          if ($_POST["action"] == "LoadMail") {
        $numero = $_POST["idAffiche"];
        $statement = $connection->prepare("SELECT O.id,
        O.objectif,
        S.couleur,
        projet.nom AS projet,
        S.nom AS etat
        FROM objectif O
        INNER JOIN statutobjectif S
          ON S.id = O.id_StatutObjectif
        INNER JOIN projet
          ON projet.id = O.id_Projet
        WHERE O.id_Sprint = $numero
        ORDER BY projet.nom");
          $statement->execute();
          $result = $statement->fetchAll();
          $output = 'Rétrospective:';

          $projet = '';

          if ($statement->rowCount() > 0) {
            foreach ($result as $row) {

              if ($projet != $row["projet"]) {
                $projet = $row["projet"];
                $output .= '<br> <br><u>' . $row["projet"] . '</u>: <br>' . '- ' . $row["objectif"] . ' (<span class="Mail' . $row["etat"] . '">' . $row["etat"] . '</span>)';
              } else {
                $output .= '<br>- ' . $row["objectif"] . ' (<span class="Mail' . $row["etat"] . '">' . $row["etat"] . '</span>)';
              }
            }
          }

          $output .= '<br> <br> Remarques: <br>';

          $statement = $connection->prepare("SELECT label
        FROM retrospective R
        WHERE R.DateFini IS NULL");
          $statement->execute();
          $result = $statement->fetchAll();

          if ($statement->rowCount() > 0) {
            foreach ($result as $row) {
              $output .= '- ' . $row["label"] . '<br>';
            }
          }

          print ($output);
        }

      
        if ($_POST["action"] == "Créer") {
        $statement = $connection->prepare("
        INSERT INTO objectif (id_Sprint, id_Projet, id_Employe, objectif, id_StatutObjectif) 
        VALUES (:id_Sprint, :id_Projet, :id_Employe, :objectif, :id_StatutObjectif)
        ");
        $result = $statement->execute(
          array(
            ':id_Sprint' => $_POST["idSprint"],
            ':id_Projet' => $_POST["idProjet"],
            ':id_Employe' => $_POST["idEmploye"],
            ':objectif' => $_POST["LabelObjectif"],
            ':id_StatutObjectif' => 5
          )
        );
        if (!empty($result))
          print 'Objectif "'.$_POST["LabelObjectif"].'" créé';
        else
          print_r($statement->errorInfo());
      }

      if ($_POST["action"] == "SelectObjectif") {
        $output = array();
        $statement = $connection->prepare(
          "SELECT * FROM objectif 
        WHERE id = '" . $_POST["id"] . "' 
        LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetch();

        $output["id_Projet"] = $result["id_Projet"];
        $output["id_Employe"] = $result["id_Employe"];
        $output["objectif"] = $result["objectif"];
        $output["id_StatutObjectif"] = $result["id_StatutObjectif"];

        print json_encode($output);
      }

      if ($_POST["action"] == "Changer Objectif") {
        $statement = $connection->prepare(
          "UPDATE objectif 
        SET objectif = :LabelObjectif, id_Sprint = :id_Sprint, id_Projet = :id_Projet, id_Employe = :id_Employe
        WHERE id = :id
        "
        );
        $result = $statement->execute(
          array(
            ':LabelObjectif' => $_POST["LabelObjectif"],
            ':id_Sprint' => $_POST["idSprint"],
            ':id_Projet' => $_POST["idProjet"],
            ':id_Employe' => $_POST["idEmploye"],
            ':id' => $_POST["id"]
          )
        );
        if (!empty($result))
          print 'Objectif "'.$_POST["LabelObjectif"].'" changé';
        else
          print_r($statement->errorInfo());
      }

      if ($_POST["action"] == "ChangerEtat") {
        $statement = $connection->prepare(
          "UPDATE objectif 
          SET id_StatutObjectif = :EtatObjectif 
          WHERE id = :id
          "
        );
        $result = $statement->execute(
          array(
            ':EtatObjectif' => $_POST["EtatObjectif"],
            ':id' => $_POST["id"]
          )
        );
        if (!empty($result))
          print 'Etat changé';
        else
          print_r($statement->errorInfo());
      }

      if ($_POST["action"] == "Delete") {
        $statement = $connection->prepare(
          "DELETE FROM objectif
        WHERE id = :id"
        );
        $result = $statement->execute(
          array(
            ':id' => $_POST["id"]
          )
        );
        if ($statement->rowCount() > 0)
          print 'Objectif supprimé';
        else
          print_r($statement->errorInfo());
      }
    }

    ?> 