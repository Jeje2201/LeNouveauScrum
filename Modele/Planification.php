   <?php

require_once('Configs.php');

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "RemplirTableau") {
        $numero = $_POST["idAffiche"];
        $statement = $connection->prepare("SELECT *
        FROM tache
        inner JOIN user ON tache_fk_user = user_pk
        INNER JOIN projet ON  tache_fk_projet = projet_pk
        WHERE tache_fk_sprint = $numero
        ORDER BY tache_pk DESC");
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
        <th class="text-center">Fini</th>
        <th class="text-center">Action</th>
        </tr>
        </thead>
        <tbody id="myTable">
        ';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {
            $output .= '
        <tr>
        <td>' . $row["user_prenom"] . ' ' . $row["user_nom"] . '</td>
        <td>' . $row["projet_nom"] . '</td>
        <td>' . $row["tache_label"] . '</td>
        <td>' . $row["tache_heure"] . '</td>';
        if ($row["tache_done"] == null)
          $output .= '<td></td>';
        else
          $output .= '<td>' . date("d/m/Y", strtotime($row["tache_done"])) . '</td>';

          $output .='<td><div class="btn-group d-flex" role="group" ><button  id="' . $row["tache_pk"] . '" class="btn btn-warning update"><i class="fa fa-pencil" aria-hidden="true"></i></button><button  id="' . $row["tache_pk"] . '" class="btn btn-danger delete"><i class="fa fa-trash" aria-hidden="true"></i></button></div></td>';
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

      if ($_POST["action"] == "RemplirTableauRessources") {
        $numero = $_POST["idAffiche"];

        $statement = $connection->prepare("SELECT sum(tache_heure) AS NbHeure,
          (
            SELECT sprint_attribuable
            FROM sprint
            WHERE sprint_pk = $numero
          ) - sum(tache_heure)
         AS Attribuable,
        user_prenom,
        user_initial
        FROM tache
        inner JOIN user ON user_pk = tache_fk_user
        WHERE tache_fk_sprint = $numero
        GROUP BY tache_fk_user    
        union 
        select 0, 60, user_prenom, user_initial  from user where user_pk not in (
        select tache_fk_user from tache where tache_fk_sprint = $numero group by tache_fk_user)
        and user_doesPlanification = 1
        order by 1 desc,3
        ");
          $statement->execute();
          $result = $statement->fetchAll();
          $output = '';
          $output .= '
        <table class="table table-sm table-bordered" id="datatable" width="100%" cellspacing="0">
        <thead class="thead-light">
        <tr>
        <th>Ressource</th>
        <th>Planifié (Dispo)</th>
        </tr>
        </thead>
        <tbody id="myTable">
        ';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {
            $output .= '
        <tr>
        <td>' . $row["user_prenom"] . ' ' . $row["user_initial"] . '</td>';
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
        print $output;
      }

      // if ($_POST["action"] == "RemplirTableauProjets") {
      //   $numero = $_POST["idAffiche"];
      //   $statement = $connection->prepare("SELECT sum(tache_heure) AS NbHeure,
      //   projet_nom
      //   FROM tache
      //   inner JOIN projet ON projet_pk = tache_fk_projet
      //   WHERE tache_fk_sprint = $numero
      //   GROUP BY tache_fk_projet
      //   ORDER BY projet_nom ASC");
      //     $statement->execute();
      //     $result = $statement->fetchAll();
      //     $output = '';
      //     $output .= '
      //   <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
      //   <thead class="thead-light">
      //   <tr>
      //   <th>Projet</th>
      //   <th>H</th>
      //   </tr>
      //   </thead>
      //   <tbody id="myTable">
      //   ';
      //   if ($statement->rowCount() > 0) {
      //     foreach ($result as $row) {
      //       $output .= '
      //   <tr>
      //   <td>' . $row["projet_nom"] . '</td>
      //   <td>' . $row["NbHeure"] . '</td>
      //   </tr>
      //   ';
      //     }
      //   } else {
      //     $output .= '
      //   <tr>
      //   <td align="center" colspan="10">Pas de données</td>
      //   </tr>
      //   ';
      //   }
      //   $output .= '</tbody></table>';
      //   print $output;
      // }

      //Créer une tache depuis la méthode x+x+x
      if ($_POST["action"] == "Attribuer") {
        $TableauHeurePlanifie = $_POST["NombreHeure"];
        $statement = $connection->prepare("
        INSERT INTO tache (tache_heure, tache_fk_sprint, tache_fk_user, tache_fk_projet, tache_label) 
        VALUES (:NombreHeure, :idSprint, :idEmploye, :idProjet, :Label)
        ");
        for ($i = 0; $i < count($TableauHeurePlanifie); $i++) {

          $result = $statement->execute(
            array(
              ':NombreHeure' => intval($TableauHeurePlanifie[$i]),
              ':idSprint' => $_POST["idSprint"],
              ':Label' => "Label inconnue",
              ':idEmploye' => $_POST["idEmploye"],
              ':idProjet' => $_POST["idProjet"]
            )
          );
        }
        if (!empty($result))
          print true;
        else
          print_r($statement->errorInfo());
      }

      //Créer une tache depuis la méthode de reunion
      // if ($_POST["action"] == "AttribuerReunion") {
      //   $TableauHeurePlanifie = $_POST["NombreHeure"];
      //   $statement = $connection->prepare("
      //   INSERT INTO tache (heure, id_Sprint, id_Employe, id_Projet, Label, tache_type) 
      //   VALUES (:NombreHeure, :idSprint, (select employe.id from employe where employe.mail like :emailEmploye), (select projet.id from projet where projet.nom like 'NS Interne'), :Label, 'Réunion')
      //   ");

      //     $result = $statement->execute(
      //       array(
      //         ':NombreHeure' => $_POST["NombreHeure"],
      //         ':idSprint' => $_POST["idSprint"],
      //         ':Label' => $_POST["Label"],
      //         ':emailEmploye' => $_POST["mailEmploye"]
      //       )
      //     );
      //   if (!empty($result))
      //       print 'Reunion bien prise en compte';
      //     else
      //       print_r($statement->errorInfo());
      // }

      //Créer une tache depuis l'api
      if ($_POST["action"] == "CreerTacheApi") {
        $ListeTache = $_POST["ListeTaches"];
        $statement = $connection->prepare("
        INSERT INTO tache (tache_heure, tache_fk_sprint, tache_fk_user, tache_fk_projet, tache_label, tache_done, tache_pivotal_id_Task, tache_pivotal_id_Story, tache_pivotal_id_Project, tache_pivotal_Label_Story) 
        VALUES (:NombreHeure, :idSprint, :idEmploye, :idProjet, :Label, :Done, :pivotal_id_Task, :pivotal_id_Story, :pivotal_id_Project, :pivotal_Label_Story)
        ");
        for ($i = 2; $i < count($ListeTache); $i++) {

          if ($ListeTache[$i]['done'] == null)
            $ListeTache[$i]['done'] = null;

          $result = $statement->execute(
            array(
              ':NombreHeure' => intval($ListeTache[$i]['heure']),
              ':idSprint' => $_POST["Sprint"],
              ':Label' => $ListeTache[$i]['label'],
              ':idEmploye' => $_POST["Employe"],
              ':idProjet' => $_POST["Projet"],
              ':Done' => $ListeTache[$i]['done'],
              ':pivotal_id_Task' => $ListeTache[$i]['TaskId'],
              ':pivotal_id_Story' => $ListeTache[$i]['StoryId'],
              ':pivotal_id_Project' => $ListeTache[$i]['ProjectId'],
              ':pivotal_Label_Story' => $ListeTache[$i]['StoryLabel']
            )
          );
        }
        if (!empty($result))
          print true;
        else
          print_r($statement->errorInfo());
      }

      //Creer des taches de type scrum planing 
      if ($_POST["action"] == "AttributionScrumPlaning") {
        $TableauEmploye = $_POST["idEmploye"];
        $numero = $_POST["idSprint"];
        $statement = $connection->prepare("INSERT INTO tache (tache_heure, tache_fk_sprint, tache_fk_user, tache_fk_projet, tache_type, tache_label) 
        VALUES (:NombreHeure, :idSprint, :idEmploye, (select projet_pk FROM projet WHERE projet_nom like 'ScrumPlanning'), :TypeTache, :LabelTache)");
        for ($i = 0; $i < count($TableauEmploye); $i++) {

          $result = $statement->execute(
            array(
              ':NombreHeure' => intval($_POST["NombreHeure"]),
              ':idSprint' => intval($_POST["idSprint"]),
              ':idEmploye' => intval($TableauEmploye[$i]),
              ':TypeTache' => $_POST["idTypeTache"],
              ':LabelTache' => $_POST["idTypeTache"]
            )
          );
          if (!empty($result))
            print true;
          else
            print_r($statement->errorInfo());
        }
      }

      if ($_POST["action"] == "NbHeureRestantePlanifiable") {
        $output = array();
        $idSprint = $_POST["Sprint"];
        $idRessource = $_POST["Employe"];
        $statement = $connection->prepare(
          "SELECT
        sprint_attribuable - sum(tache_heure) as Attribuable,
        (select sprint_attribuable from sprint where sprint_pk = $idSprint) as AttribuablePD
        FROM tache
        INNER JOIN sprint on sprint_pk = tache_fk_sprint
        where tache_fk_sprint = $idSprint
        and tache_fk_user = $idRessource"
        );
        $statement->execute();
        $result = $statement->fetch();

        if ($result["Attribuable"] == null)
          $output["Attribuable"] = intval($result["AttribuablePD"]);
        else
          $output["Attribuable"] = intval($result["Attribuable"]);

        print json_encode($output);
      }
    }

    ?> 