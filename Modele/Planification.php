   <?php

  require_once('../Modele/Configs.php');

  if (isset($_POST["action"])) {

    if ($_POST["action"] == "RemplirTableau") {
      $numero = $_POST["idAffiche"];
      $statement = $connection->prepare("SELECT A.id,
      A.Label,
      A.heure,
      A.Done,
      P.nom AS projet,
      E.prenom AS employeP,
      E.nom AS employeN
      FROM attribution A
      inner JOIN employe E
        ON E.id = A.id_Employe
      INNER JOIN projet  P
        ON P.id = A.id_Projet
      INNER JOIN sprint  S
        ON S.id = A.id_Sprint
      WHERE A.id_Sprint = $numero
      ORDER BY A.id DESC");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead class="thead-light">
      <tr>
      <th>Ressource</th>
      <th>Projet</th>
      <th>Label</th>
      <th>Heures</th>
      <th>Fini</th>
      </tr>
      </thead>
      <tbody id="myTable">
      ';
      if ($statement->rowCount() > 0) {
        foreach ($result AS $row) {
          $output .= '
        <tr>
        <td>' . $row["employeP"] . ' ' . $row["employeN"] . '</td>
        <td>' . $row["projet"] . '</td>
        <td>' . $row["Label"] . '</td>
        <td>' . $row["heure"] . '</td>';
        if ($row["Done"] == null)
            $output .= '<td></td>';
        else
          $output .= '<td>' . date("d/m/Y", strtotime($row["Done"])) . '</td>';
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

    if ($_POST["action"] == "RemplirTableauRessources") {
      $numero = $_POST["idAffiche"];

      $statement = $connection->prepare("SELECT sum(A.heure) AS NbHeure,
      (
        (
          SELECT Attribuable
          FROM sprint S
          WHERE S.id = $numero
        )- sum(A.heure)
      ) AS Attribuable,
      E.prenom AS employeP,
      E.nom AS employeN
      FROM attribution A
      inner JOIN employe E
        ON E.id = A.id_Employe
      WHERE A.id_Sprint = $numero
      GROUP BY A.id_Employe
      ORDER BY employeP ASC");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-sm table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead class="thead-light">
      <tr>
      <th>Ressource</th>
      <th>Planifié (Disponible)</th>
      </tr>
      </thead>
      <tbody id="myTable">
      ';
      if ($statement->rowCount() > 0) {
        foreach ($result AS $row) {
          $output .= '
        <tr>
        <td>' . $row["employeP"] . ' ' . $row["employeN"] . '</td>';
          if ($row["Attribuable"] == 0) {
            $output .= '<td style="background-color:#baffc9">' . $row["NbHeure"] . ' (' . $row["Attribuable"] . ')</td>';
          }
          if ($row["Attribuable"] > 0) {
            $output .= '<td>' . $row["NbHeure"] . ' (' . $row["Attribuable"] . ')</td>';
          }
          if ($row["Attribuable"] < 0) {
            $output .= '<td style="background-color:#ffb3ba">' . $row["NbHeure"] . ' (' . $row["Attribuable"] . ')</td>';
          }
          $output .= '</tr>';

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

    if ($_POST["action"] == "RemplirTableauProjets") {
      $numero = $_POST["idAffiche"];
      $statement = $connection->prepare("SELECT sum(A.heure) AS NbHeure,
      P.nom AS ProjetN
      FROM attribution A
      inner JOIN projet P
        ON P.id = A.id_Projet
      WHERE A.id_Sprint = $numero
      GROUP BY A.id_Projet
      ORDER BY ProjetN ASC");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead class="thead-light">
      <tr>
      <th>Projet</th>
      <th>H</th>
      </tr>
      </thead>
      <tbody id="myTable">
      ';
      if ($statement->rowCount() > 0) {
        foreach ($result AS $row) {
          $output .= '
        <tr>
        <td>' . $row["ProjetN"] . '</td>
        <td>' . $row["NbHeure"] . '</td>
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

    //Créer une tache depuis la méthode x+x+x
    if ($_POST["action"] == "Attribuer") {
      $TableauHeurePlanifie = $_POST["NombreHeure"];
      $statement = $connection->prepare("
   INSERT INTO attribution (heure, id_Sprint, id_Employe, id_Projet, Label) 
   VALUES (:NombreHeure, :idSprint, :idEmploye, :idProjet, :Label)
   ");
      for ($i = 0; $i < count($TableauHeurePlanifie); $i++) {

        $result = $statement->execute(
          array(
            ':NombreHeure' => intval($TableauHeurePlanifie[$i]),
            ':idSprint' => $_POST["idSprint"],
            ':Label' => "?",
            ':idEmploye' => $_POST["idEmploye"],
            ':idProjet' => $_POST["idProjet"]
          )
        );
        if (!empty($result))
          echo '✓';
        else
          print_r($statement->errorInfo());
      }
    }

    if ($_POST["action"] == "Select") {
      $output = array();
      $statement = $connection->prepare(
        "SELECT * FROM attribution 
        WHERE id = '" . $_POST["id"] . "' 
        LIMIT 1"
      );
      $statement->execute();
      $result = $statement->fetchAll();
      foreach ($result AS $row) {
        $output["heure"] = $row["heure"];
        $output["id_Employe"] = $row["id_Employe"];
        $output["id_Projet"] = $row["id_Projet"];
        $output["Done"] = $row["Done"];
      }
      echo json_encode($output);
    }

    if ($_POST["action"] == "Update") {
      $statement = $connection->prepare(
        "UPDATE attribution 
   SET heure = :heure, id_Sprint = :id_Sprint, id_Projet = :id_Projet, id_Employe = :id_Employe 
   WHERE id = :id
   "
      );
      $result = $statement->execute(
        array(
          ':heure' => $_POST["NombreHeure"],
          ':id_Sprint' => $_POST["idSprint"],
          ':id_Projet' => $_POST["idProjet"],
          ':id_Employe' => $_POST["idEmploye"],
          ':id' => $_POST["id"]
        )
      );
      if (!empty($result))
        echo ' ✓ ';
      else
        echo 'X ';
    }

    //Supprimer une tache
    if ($_POST["action"] == "Delete") {
      $statement = $connection->prepare(
        "DELETE FROM attribution
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

    //Créer une tache depuis l'api
      if ($_POST["action"] == "CreerTacheApi") {
        $ListeTache = $_POST["ListeTaches"];
        $statement = $connection->prepare("
     INSERT INTO attribution (heure, id_Sprint, id_Employe, id_Projet, Label) 
     VALUES (:NombreHeure, :idSprint, :idEmploye, :idProjet, :Label)
     ");
        for ($i = 2; $i < count($ListeTache); $i++) {
  
          $result = $statement->execute(
            array(
              ':NombreHeure' => intval($ListeTache[$i]['heure']),
              ':idSprint' => $_POST["Sprint"],
              ':Label' => $ListeTache[$i]['label'],
              ':idEmploye' => $_POST["Employe"],
              ':idProjet' => $_POST["Projet"]
            )
          );
          if (!empty($result))
            echo '✓';
          else
            print_r($statement->errorInfo());
        }
      }

    //Creer des taches de type scrum planing 
    if ($_POST["action"] == "AttributionScrumPlaning") {
      $TableauEmploye = $_POST["idEmploye"];
      $statement = $connection->prepare("INSERT INTO attribution (heure, id_Sprint, id_Employe, id_Projet, id_TypeTache, Label, Done) 
   VALUES (:NombreHeure, :idSprint, :idEmploye, (select id FROM projet P WHERE P.nom = 'ScrumPlaning'), :TypeTache, (select nom FROM typetache T WHERE T.id = :TypeTache),NOW())
   ");
      for ($i = 0; $i < count($TableauEmploye); $i++) {

        $result = $statement->execute(
          array(
            ':NombreHeure' => intval($_POST["NombreHeure"]),
            ':idSprint' => intval($_POST["idSprint"]),
            ':idEmploye' => intval($TableauEmploye[$i]),
            ':TypeTache' => intval($_POST["idTypeTache"])
          )
        );
        if (!empty($result))
          echo '✓';
        else
          print_r($statement->errorInfo());
      }
    }

  }

  ?>
