   <?php

function MinutesEnHeures($Minutes)
{
  $num = $Minutes;
  $hours = ($num / 60);
  $rhours = floor($hours);
  $minutes = ($hours - $rhours) * 60;
  $rminutes = round($minutes);
  if($rminutes < 10){
    $rminutes = "0".$rminutes;
  }

  if($rhours < 10){
    $rhours = "0".$rhours;
  }
  return $rhours . 'h' . $rminutes;
}

    session_start();
    require_once('Configs.php');

    if (isset($_POST["action"])) {

      //Load les fiches de temps de tout le monde dans la gestion des fiches de temps
      if ($_POST["action"] == "getFichesDeTemps") {
        $statement = $connection->prepare("SELECT
        fiche_de_temps_pk,
        user_prenom,
        user_initial,
        projet_nom,
        fiche_de_temps_time,
        fiche_de_temps_done
        FROM fiche_de_temps C
        inner join user on fiche_de_temps_fk_user = user_pk
        inner join projet on fiche_de_temps_fk_projet = projet_pk
        WHERE fiche_de_temps_done >= (SELECT sprint_dateDebut from sprint where sprint_pk = " . $_POST["IdSprint"] . " ) 
        and fiche_de_temps_done <= (SELECT sprint_dateFin from sprint where sprint_pk = " . $_POST["IdSprint"] . " )
        ORDER BY fiche_de_temps_done DESC");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        print json_encode($result);
      }

      // Get combien déjà remplis pour set bon % et max etc..
      if ($_POST["action"] == "GetNewMax") {
        $output = array();
        $statement = $connection->prepare(
          "SELECT sum(fiche_de_temps_time)
        FROM fiche_de_temps
        WHERE fiche_de_temps_fk_user = '" . $_SESSION['user']['id'] . "'
        AND fiche_de_temps_done = '" . $_POST["Done"] . "'"
        );
        $statement->execute();
        $result = $statement->fetch();
        print 0 + $result[0];
      }

      // Pour la liste d'heures validé sur une journée selectionné dans la page de fiche de temps
      if ($_POST["action"] == "LoadHeuresRempli1Jour1Ressource") {

        $output = array();
        $statement = $connection->prepare(
          "SELECT fiche_de_temps_time, fiche_de_temps_pk, projet_nom
        FROM fiche_de_temps
        inner join projet on fiche_de_temps_fk_projet = projet_pk
        WHERE fiche_de_temps_fk_user = " . $_SESSION['user']['id'] . "
        AND fiche_de_temps_done = '" . $_POST["Done"] . "'"
        );
        $statement->execute();
        $result = $statement->fetchAll();
        $output = '
        <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
        <thead class="thead-light">
        <tr>
        <th>Projet</th>
        <th>Heures du '.date("d/m/Y", strtotime($_POST["Done"])).'</th>
        <th class="text-center">Supprimer</th>
        </tr>
        </thead>
        <tbody id="myTable">';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {

            $output .= '
        <tr>
        <td>' . $row["projet_nom"] . '</td>
        <td>' . MinutesEnHeures($row["fiche_de_temps_time"]) . '</td>
        <td><div class="btn-group d-flex" role="group" ><button  id="' . $row["fiche_de_temps_pk"] . '" class="btn btn-danger delete"><i class="fa fa-trash" aria-hidden="true"></i></button></div></td>
        </tr>
        ';
          }
        } else {
          $output .= '
          <tr>
            <td align="center" colspan="10">Pas de données</td>
          </tr>';
        }
        $output .= '</tbody></table>';
        print $output;
      }

      //Afficher la liste des dates où il manque des fiche de temps non remplies
      if ($_POST["action"] == "TableTotJoursNonPlein") {

        $statement = $connection->prepare(
          "SELECT DISTINCT fiche_de_temps_done
          from fiche_de_temps
          WHERE fiche_de_temps_fk_user = " . $_SESSION['user']['id'] . "
          GROUP BY fiche_de_temps_done
          HAVING sum(fiche_de_temps_time)=444
          order by fiche_de_temps_done asc");

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_COLUMN);

        print json_encode($result);
      }

      //TODO supprimer cette parti là car déjà faite en dessous en full json
      //List des heures par date de rempli
      if ($_POST["action"] == "ListTotalSurDate") {
        $output = array();
        $statement = $connection->prepare(
        "SELECT
          projet_nom,
          sum(fiche_de_temps_time) as Temps
        FROM fiche_de_temps
        inner JOIN projet on projet_pk = fiche_de_temps_fk_projet
        WHERE fiche_de_temps_done >= '" . $_POST["Start"] ."'  
        and fiche_de_temps_done <= '" . $_POST["End"] ."' 
        and fiche_de_temps_fk_user = " . $_SESSION['user']['id'] . "
        GROUP BY fiche_de_temps_fk_projet
        ORDER BY Temps desc");
        
        $statement->execute();
        $result = $statement->fetchAll();
        $output = '';
        $output .= '
        <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
        <thead class="thead-light">
        <tr>
        <th>Projet</th>
        <th>Total</th>
        </tr>
        </thead>
        <tbody id="myTable">
        ';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {

            $output .= '
            <tr>
            <td>' . $row["projet_nom"] . '</td>
            <td>' . MinutesEnHeures($row["Temps"]) . '</td>
            </tr>';
          }
        } else {
          $output .= '
          <tr>
            <td align="center" colspan="10">Pas de données</td>
          </tr>';
        }
        $output .= '</tbody></table>';
        print $output;
      }

      //List des heures par date de rempli
      if ($_POST["action"] == "ListTotalSurDateSelonUser") {
        try{
          $output = array();
          $statement = $connection->prepare(
          "SELECT
            projet_nom,
            sum(fiche_de_temps_time)/444 as Temps
          FROM fiche_de_temps
          inner JOIN projet on projet_pk = fiche_de_temps_fk_projet
          WHERE fiche_de_temps_done >= '" . $_POST["Start"] ."'  
          and fiche_de_temps_done <= '" . $_POST["End"] ."' 
          and fiche_de_temps_fk_user = " . $_POST["User"] . "
          GROUP BY fiche_de_temps_fk_projet
          ORDER BY Temps desc");
          
          $statement->execute();
          $result = $statement->fetchAll(PDO::FETCH_ASSOC);
          print json_encode($result);
        }
        catch (PDOException $e) {
          header($_SERVER["SERVER_PROTOCOL"] . ' 400 ' . utf8_decode($e->getMessage()));
        }
      }

      //List des heures par sprint de rempli
      if ($_POST["action"] == "ListTotalSurSprint") {
        $output = array();
        $statement = $connection->prepare(
        "SELECT
          projet_nom,
          sum(fiche_de_temps_time) as Temps
          FROM fiche_de_temps
          inner JOIN projet on projet_pk = fiche_de_temps_fk_projet
          WHERE fiche_de_temps_done >= (SELECT sprint_dateDebut from sprint where sprint_pk = " . $_POST["LeSprint"] . " ) 
          AND fiche_de_temps_done <= (SELECT sprint_dateFin from sprint where sprint_pk = '" . $_POST["LeSprint"] . "' )
          and fiche_de_temps_fk_user = " . $_SESSION['user']['id'] . "
          group by fiche_de_temps_fk_projet");
        
        $statement->execute();
        $result = $statement->fetchAll();
        $output = '';
        $output .= '
        <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
        <thead class="thead-light">
        <tr>
        <th>Projet</th>
        <th>Total</th>
        </tr>
        </thead>
        <tbody id="myTable">
        ';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {

            $output .= '
            <tr>
            <td>' . $row["projet_nom"] . '</td>
            <td>' . MinutesEnHeures($row["Temps"]) . '</td>
            </tr>';
          }
        } else {
          $output .= '
          <tr>
            <td align="center" colspan="10">Pas de données</td>
          </tr>';
        }
        $output .= '</tbody></table>';
        print $output;
      }

      //List des heures par ressources pour un projet sur une plage horaire
      if ($_POST["action"] == "ListeSelonProjetDateRessource") {
        $output = array();
        $statement = $connection->prepare(
        " SELECT
        sum(fiche_de_temps_time) as Temps
        FROM fiche_de_temps
        inner join user on fiche_de_temps_fk_user = user_pk
        WHERE fiche_de_temps_done >= '" . $_POST["Start"] ."'
        and fiche_de_temps_done <= '" . $_POST["Finish"] ."'
        and fiche_de_temps_fk_projet = ".$_POST["ProjetId"]);
        
        $statement->execute();
        $resultN0 = $statement->fetch();

        if($resultN0[0] == NULL){
          $resultN0[0] = 0;
        }

        $statement = $connection->prepare(
        " SELECT
        CONCAT(user_prenom,'&nbsp;',user_initial) AS Ressource,
        sum(fiche_de_temps_time) as Temps
        FROM fiche_de_temps
        inner JOIN user on user_pk = fiche_de_temps_fk_user
        WHERE fiche_de_temps_done >= '" . $_POST["Start"] ."'
        AND fiche_de_temps_done <= '" . $_POST["Finish"] ."' 
        and fiche_de_temps_fk_projet = ".$_POST["ProjetId"]."
        group by Ressource
        ORDER BY Temps DESC");
        
        $statement->execute();
        $result = $statement->fetchAll();
        $output = '
        <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
        <thead class="thead-light">
        <tr>
        <th>Ressource</th>
        <th>Heures (Total: '.MinutesEnHeures($resultN0[0]).')</th>
        </tr>
        </thead>
        <tbody id="myTable">
        ';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {

            $output .= '
            <tr>
            <td>' . $row["Ressource"] . '</td>
            <td>' . MinutesEnHeures($row["Temps"]) . '</td>
            </tr>';
          }
        } else {
          $output .= '
          <tr>
            <td align="center" colspan="10">Pas de données</td>
          </tr>';
        }
        $output .= '</tbody></table>';
        print $output;
      }

      //Create une fiche de temps
      if ($_POST["action"] == "addFicheDeTemps") {
        
        $LesDates = $_POST["Done"];
        $Time = $_POST["Time"];
        $DatesOk = true;
        $ListeText = "";

        //pour chaque date
        for ($i = 0; $i < sizeof($LesDates); $i++) {

          $LaDate = date("Y-m-d", strtotime($LesDates[$i]));
          //on check
          $statement = $connection->prepare(
            "SELECT
          IFNULL(sum(fiche_de_temps_time)+$Time,0) as Depasse, fiche_de_temps_done
          from fiche_de_temps
          where fiche_de_temps_fk_user = '" . $_SESSION['user']['id'] . "'
          and fiche_de_temps_done = '$LaDate'"
          );

          $statement->execute();
          $result = $statement->fetch();

          //si on dépase pour une de toutes ces dates on warn le user mais rien de plus
          if($result["Depasse"] > 444){
            $Liste[] = $LesDates[$i];
            $ListeText .= '- '.$LesDates[$i] . "<br>";
            $DatesOk = false;
          }
        }

        $JsonResult['Liste'] = $Liste;
        $JsonResult['Texte'] = $ListeText;

        if($DatesOk){
          for ($i = 0; $i < sizeof($LesDates); $i++) {

            $LaDate = date("Y-m-d", strtotime($LesDates[$i]));
            if(date('w', strtotime($LaDate)) != 0 && date('w', strtotime($LaDate)) != 6){

              try{
                  $statement = $connection->prepare("
                  INSERT INTO fiche_de_temps (fiche_de_temps_fk_user, fiche_de_temps_fk_projet, fiche_de_temps_time, fiche_de_temps_done) 
                  VALUES (:Fk_User, :Fk_Project, :Time, :Done)");
          
                    $result = $statement->execute(
                      array(
                        ':Fk_User' => $_SESSION['user']['id'],
                        ':Fk_Project' => $_POST["Projet"],
                        ':Time' => $_POST["Time"],
                        ':Done' => $LaDate
                      )
                    );
                  } catch (PDOException $e) {
                    header($_SERVER["SERVER_PROTOCOL"] . ' 400 ' . utf8_decode($e->getMessage()));
                  }
                }
        }
        }
        print json_encode($JsonResult);
      }

      //Select une fiche de temps
      if ($_POST["action"] == "Select") {
        $output = array();
        $statement = $connection->prepare(
          "SELECT * FROM fiche_de_temps 
        WHERE fiche_de_temps_pk = '" . $_POST["id"] . "' 
        LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetch();

        print json_encode($result);
      }

      //Update une fiche de temps
      if ($_POST["action"] == "Update") {

        $statement = $connection->prepare(
          "UPDATE fiche_de_temps
        SET fiche_de_temps_fk_user = :User, fiche_de_temps_fk_projet= :Project, fiche_de_temps_time = :Temps, fiche_de_temps_done = :Done 
        WHERE fiche_de_temps_pk = :id"
        );
        $result = $statement->execute(
          array(
            ':User' => $_POST["Employe"],
            ':Project' => $_POST["Projet"],
            ':Temps' => $_POST["Time"],
            ':Done' => $_POST["Done"],
            ':id' => $_POST["id"]
          )
        );
        if (!empty($result))
          print true;
        else
          print_r($statement->errorInfo());
      }

      //Delete une fiche de temps
      if ($_POST["action"] == "Delete") {
        $statement = $connection->prepare(
          "DELETE FROM fiche_de_temps WHERE fiche_de_temps_pk = :id"
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

      //Liste pour généré la chart des nb de feuilles de temps non remplies par ressource dans gestion
      if ($_POST["action"] == "RetardEnGeneral") {

        //Liste les users qui devraient remplir la feuille de temps
        $statement = $connection->prepare(
            "SELECT user_pk, user_registerDate, CONCAT(user_prenom,' ', user_initial) AS user_nom
               FROM user
              WHERE user_mailCir = 1 
                AND user_actif = 1
                order by user_prenom"
        );

        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {

          $statement = $connection->prepare(
            "SELECT fiche_de_temps_done
            From fiche_de_temps
            where fiche_de_temps_fk_user = ". $row['user_pk'] . "
            and fiche_de_temps_done >= (SELECT user_registerDate from user where user_pk = ". $row['user_pk'] . ")
            and fiche_de_temps_done <= NOW()
            and DAYOFWEEK(fiche_de_temps_done) != 1
            and DAYOFWEEK(fiche_de_temps_done) != 7
            group by fiche_de_temps_done, fiche_de_temps_fk_user
            having sum(fiche_de_temps_time)=444
            ");
            $statement->execute();

            $NouvelleEntree['NbDate'] = $statement->rowCount()+1;;
            $NouvelleEntree['user_id'] = $row['user_pk'];
            $NouvelleEntree['user_nom'] = $row['user_nom'];
            $NouvelleEntree['user_RegisterDate'] = $row['user_registerDate'];

            $Liste[] = $NouvelleEntree;
        }

        print json_encode($Liste);
      }
    }

    ?> 