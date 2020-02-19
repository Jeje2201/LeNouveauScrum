    <?php
    session_start();
    require_once('Configs.php');

    if (isset($_POST["action"])) {


      if ($_POST["action"] == "DeleteTache") {
        $statement = $connection->prepare(
          "DELETE FROM tache
         WHERE tache_pk = :id"
        );
        $result = $statement->execute(
          array(
            ':id' => $_POST["id"]
          )
        );
        if ($statement->rowCount() > 0)
          print true;
        else
          print_r($statement->errorInfo());
      }

            //Mettre a jour une tache
            if ($_POST["action"] == "UpdateTache") {

              if ($_POST["Done"] == "")
                $_POST["Done"] = null;
      
              $statement = $connection->prepare(
                "UPDATE tache
                SET
                tache_heure = :heure,
                tache_fk_sprint = :id_Sprint,
                tache_fk_projet = :id_Projet,
                tache_done = :Done,
                tache_label = :Label,
                tache_fk_user = :id_Employe 
                WHERE tache_pk = :id"
              );
              $result = $statement->execute(
                array(
                  ':heure' => $_POST["NombreHeure"],
                  ':Done' => $_POST["Done"],
                  ':Label' => $_POST["Label"],
                  ':id_Sprint' => $_POST["idSprint"],
                  ':id_Projet' => $_POST["idProjet"],
                  ':id_Employe' => $_POST["idEmploye"],
                  ':id' => $_POST["id"]
                )
              );
              if (!empty($result))
                print true;
              else
                print_r($statement->errorInfo());
            }

      //Get les information d'une tache
      if ($_POST["action"] == "GetTache") {
        $output = array();
        $statement = $connection->prepare(
          "SELECT * FROM tache 
         WHERE tache_pk = '" . $_POST["id"] . "' 
         LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetch();

        $output["heure"] = $result["tache_heure"];

        if ($result["tache_done"] == null)
          $output["Done"] = "";
        else
          $output["Done"] = date("d-m-Y", strtotime($result["tache_done"]));

        $output["Label"] = $result["tache_label"];
        $output["id_Employe"] = $result["tache_fk_user"];
        $output["id_Projet"] = $result["tache_fk_projet"];

        print json_encode($output);
      }

      //Fonction pour afficher les cards a DESCendre et DESCendues
      if ($_POST["action"] == "AfficherCards") {

        $numero = $_POST["idAffiche"];

        $statement = $connection->prepare("SELECT *
          FROM tache
          INNER JOIN projet ON projet_pk = tache_fk_projet
          WHERE tache_fk_sprint = " . $_POST["idAffiche"] . "
          AND tache_fk_user = " . $_SESSION['user']['id'] . "
          ORDER BY tache_pivotal_id_Project desc, tache_pivotal_id_Story, tache_pivotal_id_Task, projet_nom");

        $statement->execute();
        $result = $statement->fetchAll();
        $output1 = '';
        $SameStory = '-';
        if ($statement->rowCount() > 0) {
          $LeCounterDeGroupe = 0;
          foreach ($result as $row) {

            if (file_exists("../Assets/Image/Projets/avatar_projet_" . $row["projet_pk"] .".png")) {
              $row["projet_avatar"] = "avatar_projet_" . $row["projet_pk"] .".png";
            }else{
              $row["projet_avatar"] = "default.png";
            }

            $ShowItsPivotal = '';
            if($row["tache_pivotal_id_Task"] != '')
            $ShowItsPivotal = '<span class="text-warning"> (Pivotal)</span>';
            else{
              $row["tache_label"] = '<b>' . $row["projet_nom"] . '</b> - '. $row["tache_label"] ;
              $row["projet_nom"] = '';
            }

            $GroupStory = '';
            if($SameStory != $row["tache_pivotal_id_Story"]){

             
            $GroupStory = ' </div><div class="card cardGroupTache mb-3"><div class="card-header"><img class="LogoProjet" src="Assets/Image/Projets/' . $row["projet_avatar"] . '"> <b>' . $row["projet_nom"] . '</b> '. $row["tache_pivotal_Label_Story"].' '. $ShowItsPivotal.'</div>';
            $SameStory = $row["tache_pivotal_id_Story"];
          }

            if($row["tache_done"] == ""){
              $classOfTache = "pointer";
              $Fonction = 'onclick="DeplaceToi(this)"';
            }
            else{
              $classOfTache = "PASTOUCHE";
              $Fonction = '';
            }

            $output1 .= $GroupStory . '
      <div class="card '.$classOfTache.' my-1" id="' . $row["tache_pk"] . '" '.$Fonction.'>
      <img style="display:none" src="Assets/Image/Autre/CheckedTache.png">
          <span id="LabelDeLaTache" class="float-right">' . $row["tache_label"] . '</span><span> (' . $row["tache_heure"] . ')</span>
        <span class="hideElement" id="TaskId">'. $row["tache_pivotal_id_Task"].'</span><span class="hideElement" id="StoryId">'. $row["tache_pivotal_id_Story"].'</span><span class="hideElement" id="ProjectIdPivotal">'. $row["tache_pivotal_id_Project"].'</span></div>';
          }
        } else {
          $output1 .= '';
        }

        print $output1;
      }

      //Ressortir la date min et max du sprint
      if ($_POST["action"] == "DateMinMax") {

        // $idAffiche = $_POST["idAffiche"];

        $statement = $connection->prepare(
          $sql = "SELECT *
          FROM sprint
          WHERE sprint_pk = ".$_POST["idAffiche"]
        );
        $statement->execute();
        $result = $statement->fetch();

        print json_encode($result);
      }

      //Valider une tache, soit lui donner une date de validation
      if ($_POST["action"] == "Descendre") {

          $statement = $connection->prepare("UPDATE tache
          set tache_done = :done
          WHERE tache_pk = :id");

          $result = $statement->execute(
            array(
              ':done' => $_POST["LeJourDeDescente"],
              ':id' => $_POST["IdAttribue"]
            )
          );
        if (!empty($result))
          print true;
        else
          print_r($statement->errorInfo());
      }

      if ($_POST["action"] == "Load_LabelTache") {
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
        <td><input class="form-control" name="LabelObjectif" onkeyup="ListInputChanged(this)" id="' . $row["tache_pk"] . '" type="text" value="' . $row["tache_label"] . '"></td>
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

      if ($_POST["action"] == "Changer_LabelTache") {

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