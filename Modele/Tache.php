    <?php
    session_start();
    require_once('../Modele/Configs.php');

    //Si jamais le texte d'une tache risque de casser l'html qui ressort
    function PreviewText($input)
    {
      $Problem = array("<", ">");
      $input = str_replace($Problem, "", $input);

      return $input;
    }

    if (isset($_POST["action"])) {

      //Fonction pour afficher les cards a DESCendre et DESCendues
      if ($_POST["action"] == "AfficherCards") {

        $numero = $_POST["idAffiche"];

        $statement = $connection->prepare("SELECT *
          FROM tache
          INNER JOIN projet ON projet_pk = tache_fk_projet
          WHERE tache_fk_sprint = " . $_POST["idAffiche"] . "
          
          AND tache_fk_user = " . $_SESSION['user']['id'] . "
          ORDER BY projet_nom, tache_pivotal_id_Project desc, tache_pivotal_id_Story, tache_pivotal_id_Task");

        $statement->execute();
        $result = $statement->fetchAll();
        $output1 = '';
        $SameStory = '';
        if ($statement->rowCount() > 0) {
          $LeCounterDeGroupe = 0;
          foreach ($result as $row) {

            if($row["projet_avatar"] == null){
              $row["projet_avatar"] = 'default.png';
            }

            $ShowItsPivotal = '';
            if($row["tache_pivotal_id_Task"] != '')
            $ShowItsPivotal = '<span class="text-warning"> (Pivotal)</span>';

            $GroupStory = '';
            if($SameStory != $row["tache_pivotal_id_Story"]){
              $LeCounterDeGroupe +=1;

             
            $GroupStory = ' </div><div id="GroupOfTacheN'.$LeCounterDeGroupe.'" class="card cardGroupTache mb-3"><div class="card-header"><img class="LogoProjet" src="Assets/Image/Projets/' . $row["projet_avatar"] . '"> <b>' . $row["projet_nom"] . '</b> '. $row["tache_pivotal_Label_Story"].' '. $ShowItsPivotal.'</div>';
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
      <div class="card '.$classOfTache.' TacheOfGroupN'.$LeCounterDeGroupe.' my-1" id="' . $row["tache_pk"] . '" '.$Fonction.'>

          <span id="LabelDeLaTache" class="float-right">' . PreviewText($row["tache_label"]) . '</span><span> (' . $row["tache_heure"] . ')</span>
        <span class="hideElement" id="TaskId">'. $row["tache_pivotal_id_Task"].'</span><span class="hideElement" id="StoryId">'. $row["tache_pivotal_id_Story"].'</span><span class="hideElement" id="ProjectIdPivotal">'. $row["tache_pivotal_id_Project"].'</span></div>';
          }
        } else {
          $output1 .= '';
        }

        print json_encode($output1);
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

        $IdAttribue = $_POST["IdAttribue"];

        for ($i = 0; $i < sizeof($IdAttribue); $i++) {

          $statement = $connection->prepare("UPDATE tache
          set tache_done = :done
          WHERE tache_pk = :id");

          $result = $statement->execute(
            array(
              ':done' => $_POST["LeJourDeDescente"],
              ':id' => $IdAttribue[$i]
            )
          );
        }
        if (!empty($result))
          print sizeof($IdAttribue)." tâche(s) validée(s)";
        else
          print_r($statement->errorInfo());
      }
    }

    ?> 