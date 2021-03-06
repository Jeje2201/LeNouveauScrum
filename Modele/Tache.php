    <?php
    session_start();
    require_once('Configs.php');

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "DeleteTache") {
        try{
        $statement = $connection->prepare(
          "DELETE FROM tache
         WHERE tache_pk = :id"
        );
        $result = $statement->execute(
          array(
            ':id' => $_POST["id"]
          )
        );
        print "Tâche supprimée";
        } catch (PDOException $e) {
          header($_SERVER["SERVER_PROTOCOL"] . ' 400 ' . utf8_decode($e->getMessage()));
        }
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
          $output["Done"] = $result["tache_done"];

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

            if (file_exists("../Assets/Image/Projets/avatar_projet_" . $row["projet_pk"] .".png") && $row["tache_pivotal_Label_Story"] != "Tâches planifiées normalement") {
              $row["projet_avatar"] = "avatar_projet_" . $row["projet_pk"] .".png";
            }else{
              $row["projet_avatar"] = "default.png";
            }

            $ShowItsPivotal = '';
            if($row["tache_pivotal_id_Task"] != '')
            $ShowItsPivotal = '<span class="text-warning"> (Pivotal)</span>';
            else{
              $row["tache_label"] = $row["projet_nom"] .  ' : '. $row["tache_label"];
              $row["projet_nom"] = '';
            }

            $GroupStory = '';
            if($SameStory != $row["tache_pivotal_id_Story"]){

             
            $GroupStory = ' </div>
              <div class="cardGroupTache border mb-4">
                <div class="border-bottom pl-2 py-2" style="background-color: #f5f5f5d4;">
                  <img class="LogoProjet" src="Assets/Image/Projets/' . $row["projet_avatar"] . '">
                  <b>' . $row["projet_nom"] . '</b>
                  <u><a class="text-dark" href="https://www.pivotaltracker.com/story/show/'. $row["tache_pivotal_id_Story"].'" target="_blank">'. $row["tache_pivotal_Label_Story"].'</a></u>
                  '. $ShowItsPivotal.'
                </div>';
            $SameStory = $row["tache_pivotal_id_Story"];
          }

            if($row["tache_done"] == ""){
              $classDisable = 'TacheEnCours';
              $inputTacheChecked = "";
              $style= "";
            }
            else{
              $classDisable = 'TacheFini';
              $inputTacheChecked = "checked disabled";
              $style= "pointer-events: none; opacity: 0.4;";
            }

            $output1 .= $GroupStory . '
            <div class="row ml-2 border-bottom '. $classDisable . '">
                <div class="col-8 DivContentTache my-auto">
                  <span id="LabelDeLaTache" class="">' . $row["tache_label"] . '</span>
                  <span class="hideElement" id="TaskId">'. $row["tache_pk"] . '</span>
                  <span class="hideElement" id="TaskId_Pivotal">'. $row["tache_pivotal_id_Task"].'</span>
                  <span class="hideElement" id="StoryId_Pivotal">'. $row["tache_pivotal_id_Story"].'</span>
                  <span class="hideElement" id="ProjectId_Pivotal">'. $row["tache_pivotal_id_Project"].'</span>
               </div>
                <div class="col my-auto">
                  <span>' . $row["tache_heure"] . '</span>
                </div>
              <div class="col my-auto">
                <button class="btn btn-warning EditerTexteTache my-1" style="'.$style.'"><i class="fa fa-fw fa fa-pencil" aria-hidden="true"></i></button>
                <button class="btn btn-success ValiderTache my-1" style="'.$style.'" data-heure-planifie="'. $row["tache_heure"] .'"><i class="fa fa-fw fa-check" aria-hidden="true"></i></button>
              </div>
            </div>';
          }
        } else {
          $output1 = "<h4 class='mt-2'>Il serait peut être temps de faire ta planification ?</h4>";
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
          set tache_done = :done,
          tache_hours_spent = :HoursSpent
          WHERE tache_pk = :id");

          $result = $statement->execute(
            array(
              ':done' => $_POST["LeJourDeDescente"],
              ':HoursSpent' => $_POST["HoursSpent"],
              ':id' => $_POST["IdAttribue"]
            )
          );
        if (!empty($result))
          print true;
        else
          print_r($statement->errorInfo());
      }

      if ($_POST["action"] == "Changer_LabelTache") {

        $statement = $connection->prepare(
          "UPDATE tache 
        SET tache_label = :Label 
        WHERE tache_pk = :id"
        );

          $result = $statement->execute(
            array(
              ':id' => $_POST["IdTache"],
              ':Label' => $_POST["TextTache"]
            )
          );
          if (!empty($result))
          print "Tâche modifiée";
          else
            header($_SERVER["SERVER_PROTOCOL"].' 400 '.utf8_decode('Erreur de mise à jour de la tâche'));
        }
      }

    ?> 