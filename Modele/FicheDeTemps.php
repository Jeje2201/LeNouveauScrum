   <?php

    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      //Load les fiches de temps de tout le monde dans la gestion des fiches de temps
      if ($_POST["action"] == "Load") {
        $statement = $connection->prepare("SELECT
        C.id,
        CONCAT(E.prenom,' ', E.initial) AS Ressource,
        P.nom as Projet,
        C.Time,
        C.Done,
        C.Log
        FROM cir C
        inner join employe E on C.Fk_User = E.id
        inner join projet P on C.Fk_Project = P.id
        ORDER BY C.Done DESC");

        $statement->execute();
        $result = $statement->fetchAll();
        $output = '';
        $output .= '
        <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
        <thead class="thead-light">
        <tr>
        <th width="">Ressource</th>
        <th width="">Projet</th>
        <th width="">Journée</th>
        <th width="">Effectué le</th>
        <th width="">Enregistré</th>
        <th width=""><center>Éditer</center></th>
        </tr>
        </thead>
        <tbody id="myTable">';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {
            $output .= '
            <tr>
            <td>' . $row["Ressource"] . '</td>
            <td>' . $row["Projet"] . '</td>
            <td>' . $row["Time"] . '</td>
            <td>' . date("d/m/Y", strtotime($row["Done"])) . '</td>
            <td>' . date("d/m/Y", strtotime($row["Log"])) . '</td>
            <td><center><div class="btn-group" role="group" ><button type="button" id="' . $row["id"] . '" class="btn btn-warning Get"><i class="fa fa-pencil" aria-hidden="true"></i></button><button type="button" id="' . $row["id"] . '" class="btn btn-danger delete"><i class="fa fa-times" aria-hidden="true"></i></button></div></center></td>
            </tr>';
          }
        } else {
            $output .= '
            <tr>
            <td align="center" colspan="10">Pas de données</td>
            </tr>';
        }
        $output .= '</tbody></table>';
        echo $output;
      }

      // Pour la liste "Oublie sur une date" dans la gestion des fiches de temps 
      if ($_POST["action"] == "LoadSelonDate") {

        $LaDate = $_POST["LaDate"];

        $statement = $connection->prepare("SELECT CONCAT(X.prenom,' ', X.nom) as Ressource
        from employe X
        where X.id not in (SELECT
        C.Fk_User
        FROM cir C
        where C.Done = '$LaDate'
        group by C.Done, C.Fk_User
        having sum(C.Time) = 444)
        and X.actif = 1
        and X.MailCir = 1
        and X.RegisterDate <= '$LaDate'
        order by X.prenom");

        $statement->execute();
        $result = $statement->fetchAll();
        $output = '';
        $TotLol = 0;
        foreach ($result as $row) {
          $TotLol +=1;
        }
        $output .= '
        <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
        <thead class="thead-light">
        <tr>
        <th>Ressource ('.$TotLol.')</th>
        </tr>
        </thead>
        <tbody id="myTable">';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {
            $output .= '
            <tr>
              <td>' . $row["Ressource"] . '</td>
            </tr>';
          }
        } else {
          $output .= '
          <tr>
            <td align="center" colspan="10">Pas de données</td>
          </tr>';
        }
        $output .= '</tbody></table>';
        echo $output;
      }

      // Get le nb de temps pour set le max du slider
      if ($_POST["action"] == "GetNewMax") {
        $output = array();
        $statement = $connection->prepare(
          "SELECT sum(C.Time)
        FROM cir C
        inner join projet P on C.Fk_Project = P.id 
        WHERE Fk_User = '" . $_POST["Ressource"] . "'
        AND Done = '" . $_POST["Done"] . "'"
        );
        $statement->execute();
        $result = $statement->fetch();
        echo 0 + $result[0];
      }

      // Pour la liste d'heures validé sur une journée selectionné dans la page de fiche de temps
      if ($_POST["action"] == "LoadHeuresRempli1Jour1Ressource") {

        $output = array();
        $statement = $connection->prepare(
          "SELECT C.Time, C.id, P.Nom as Projet
        FROM cir C
        inner join projet P on C.Fk_Project = P.id 
        WHERE Fk_User = '" . $_POST["LaRessource"] . "'
        AND Done = '" . $_POST["Done"] . "'"
        );
        $statement->execute();
        $result = $statement->fetchAll();
        $output = '';
        $output .= '
        <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
        <thead class="thead-light">
        <tr>
        <th width="">Projet</th>
        <th width="">Heures du '.date("d/m/Y", strtotime($_POST["Done"])).'</th>
        <th width="10%"><center>Supprimer</center></th>
        </tr>
        </thead>
        <tbody id="myTable">';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {

            $num = $row["Time"];
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

            $output .= '
        <tr>
        <td>' . $row["Projet"] . '</td>
        <td>' . $rhours . 'h' . $rminutes . '</td>
        <td><center><div class="btn-group" role="group" ><button type="button" id="' . $row["id"] . '" class="btn btn-danger delete"><i class="fa fa-times" aria-hidden="true"></i></button></div></center></td>
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
        echo $output;
      }

      //Afficher la liste des dates où il manque des fiche de temps non remplies
      if ($_POST["action"] == "TableTotJoursNonPlein") {
        $output = array();
        $statement = $connection->prepare(
        "SELECT * from 
        (select adddate('1970-01-01',t4*10000 + t3*1000 + t2*100 + t1*10 + t0) selected_date from
         (select 0 t0 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
         (select 0 t1 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
         (select 0 t2 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
         (select 0 t3 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
         (select 0 t4 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
        where selected_date between (SELECT E.RegisterDate from employe E where E.id = '" . $_POST["LaRessource"] . "' and E.MailCir = 1) and now()
        and DAYOFWEEK(selected_date) != 1 and DAYOFWEEK(selected_date) != 7
        and selected_date not in (SELECT distinct C.Done
        From cir C
        where C.Fk_User = '" . $_POST["LaRessource"] . "'
        group by C.Done, C.Fk_User
        having sum(C.Time)=444)"
        );
        $statement->execute();
        $result = $statement->fetchAll();
        $output = '';
        $output .= '
        <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
        <thead class="thead-light">
        <tr>
        <th width="">Feuilles de temps non remplis</th>
        </tr>
        </thead>
        <tbody id="myTable">
        ';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {
            $output .= '
            <tr>
              <td class="ListeDateManquante"><u>' . date("d/m/Y", strtotime($row["selected_date"])) . '</u></td>
            </tr>';
          }
        } else {
          $output .= '
          <tr>
            <td align="center" colspan="10">Pas de données</td>
          </tr>';
        }
        $output .= '</tbody></table>';
        echo $output;
      }

      //List des heures par sprint de rempli
      if ($_POST["action"] == "ListTotalSurSprint") {
        $output = array();
        $statement = $connection->prepare(
        "SELECT
          projet.nom as Projets,
          sum(C.Time) as Temps
        FROM `cir` C
        inner JOIN projet on
          projet.id = C.Fk_Project
        WHERE Done >= (SELECT S.dateDebut from sprint S where S.id = '" . $_POST["LeSprint"] . "' ) 
        and Done <= (SELECT S.dateFin from sprint S where S.id = '" . $_POST["LeSprint"] . "' )
        and Fk_User = '" . $_POST["LaRessource"] . "' group by Fk_Project");
        
        $statement->execute();
        $result = $statement->fetchAll();
        $output = '';
        $output .= '
        <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
        <thead class="thead-light">
        <tr>
        <th width="">Projet</th>
        <th width="">temps</th>
        </tr>
        </thead>
        <tbody id="myTable">
        ';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {

            $num = $row["Temps"];
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

            $output .= '
            <tr>
            <td>' . $row["Projets"] . '</td>
            <td>' . $rhours . 'h' . $rminutes . '</td>
            </tr>';
          }
        } else {
          $output .= '
          <tr>
            <td align="center" colspan="10">Pas de données</td>
          </tr>';
        }
        $output .= '</tbody></table>';
        echo $output;
      }

      //Create une fiche de temps
      if ($_POST["action"] == "Create") {

        $Ressource = $_POST["Ressource"];
        $LesDates = $_POST["Done"];
        $Time = $_POST["Time"];
        $DatesOk = true;
        $JsonResult = [];
        $Liste = [];
        $ListeText = "";

        //pour chaque date
        for ($i = 0; $i < sizeof($LesDates); $i++) {

          $LaDate = date("Y-m-d", strtotime($LesDates[$i]));
          //on check
          $statement = $connection->prepare(
            "SELECT
          IFNULL(sum(Time)+$Time,0) as Depasse
          from cir
          where Fk_User = $Ressource
          and Done = '$LaDate'"
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

            $statement = $connection->prepare("
            INSERT INTO cir (Fk_User, Fk_Project, Time, Done, Log) 
            VALUES (:Fk_User, :Fk_Project, :Time, :Done, :Log)");
    
              $result = $statement->execute(
                array(
                  ':Fk_User' => $_POST["Ressource"],
                  ':Fk_Project' => $_POST["Projet"],
                  ':Time' => $_POST["Time"],
                  ':Done' => $LaDate,
                  ':Log' => $_POST["Log"]
                )
              );
              if (empty($result)){
                print_r($statement->errorInfo());
              } 
          }
        }
        echo json_encode($JsonResult);
      }

      //Select une fiche de temps
      if ($_POST["action"] == "Select") {
        $output = array();
        $statement = $connection->prepare(
          "SELECT * FROM cir 
        WHERE id = '" . $_POST["id"] . "' 
        LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetch();

        $output["Done"] = date("d-m-Y", strtotime($result["Done"]));
        $output["Log"] = date("d-m-Y", strtotime($result["Log"]));
        $output["Time"] = $result["Time"];
        $output["Ressource"] = $result["Fk_User"];
        $output["Projet"] = $result["Fk_Project"];

        echo json_encode($output);
      }

      //Update une fiche de temps
      if ($_POST["action"] == "Update") {

        $statement = $connection->prepare(
          "UPDATE cir
        SET Fk_User = :User, Fk_Project= :Project, Time = :Time, Done = :Done, Log = :Log 
        WHERE id = :id"
        );
        $result = $statement->execute(
          array(
            ':User' => $_POST["Employe"],
            ':Project' => $_POST["Projet"],
            ':Time' => $_POST["Time"],
            ':Done' => $_POST["Done"],
            ':Log' => $_POST["Log"],
            ':id' => $_POST["id"]
          )
        );
        if (!empty($result))
          echo '✓';
        else {
          print_r($statement->errorInfo());
        }
      }

      //Delete une fiche de temps
      if ($_POST["action"] == "Delete") {
        $statement = $connection->prepare(
          "DELETE FROM cir WHERE id = :id"
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

      //Liste pour généré la chart des nb de feuilles de temps non remplies par ressource dans gestion
      if ($_POST["action"] == "RetardEnGeneral") {

        $array = [];

        //Liste les users qui devraient remplir la feuille de temps
        $statement = $connection->prepare(
            "SELECT E.id AS id, CONCAT(E.prenom,' ', E.initial) AS User
               FROM employe E
              WHERE E.MailCir = 1 
                AND E.Actif = 1
                order by E.prenom"
        );

        $statement->execute();
        $result = $statement->fetchAll();

        $id = [];
        $NomUser = [];

        foreach ($result as $row) {
          $id[] = $row['id'];
          $NomUser[] = $row['User'];
        }

        $array['ListId'] = $id;
        $array['NomUser'] = $NomUser;

        $NbDate = [];

        foreach ($array['ListId'] as $UnId) {

          $statement = $connection->prepare(
          "SELECT * from 
          (
              select adddate('1970-01-01',t4*10000 + t3*1000 + t2*100 + t1*10 + t0) selected_date from
           (select 0 t0 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
           (select 0 t1 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
           (select 0 t2 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
           (select 0 t3 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
           (select 0 t4 union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4
          ) as test
          where selected_date between (
              SELECT E.RegisterDate from employe E where E.id = $UnId
          ) and now()
          and DAYOFWEEK(selected_date) != 1 and DAYOFWEEK(selected_date) != 7
          and selected_date not in (
              SELECT distinct C.Done
              From cir C
              where C.Fk_User = $UnId
              group by C.Done, C.Fk_User
              having sum(C.Time)=444
          )");

          $statement->execute();

          $NbDate[] = $statement->rowCount();
        }

        $array['NbDatePerUser'] = $NbDate;

        echo json_encode($array);
      }
    }

    ?> 