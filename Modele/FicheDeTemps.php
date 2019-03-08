   <?php

  require_once('../Modele/Configs.php');

  if (isset($_POST["action"])) {

    //Load les fiches de temps
    if ($_POST["action"] == "Load") {
      $statement = $connection->prepare("SELECT
      C.id,
      CONCAT(E.prenom,' ', E.initial) AS Ressource,
      P.nom as Projet,
      C.Time,
      C.Done,
      C.Log
      FROM Cir C
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
      <tbody id="myTable">
      ';
      if ($statement->rowCount() > 0) {
        foreach ($result AS $row) {
          $output .= '
        <tr>
        <td>' . $row["Ressource"] . '</td>
        <td>' . $row["Projet"] . '</td>
        <td>' . $row["Time"] . '</td>
        <td>' . date("d/m/Y", strtotime($row["Done"])) . '</td>
        <td>' . date("d/m/Y", strtotime($row["Log"])) . '</td>
        <td><center><div class="btn-group" role="group" aria-label="Basic example"><button type="button" id="' . $row["id"] . '" class="btn btn-warning Get"><i class="fa fa-pencil" aria-hidden="true"></i></button><button type="button" id="' . $row["id"] . '" class="btn btn-danger delete"><i class="fa fa-times" aria-hidden="true"></i></button></div></center></td>
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

    //Create une fiche de temps
    if ($_POST["action"] == "Create") {

      $Ressource = $_POST["Ressource"];
      $Date = $_POST["Done"];
      $Time = $_POST["Time"];

      $statement = $connection->prepare(
        "SELECT
        IFNULL(sum(Time)+$Time,0) as Depasse
        from CIR
        where Fk_User = $Ressource
        and Done = '$Date'");

      $statement->execute();
      $result = $statement->fetch();

      If($result["Depasse"] <= 1){

        $statement = $connection->prepare("
        INSERT INTO Cir (Fk_User, Fk_Project, Time, Done, Log) 
        VALUES (:Fk_User, :Fk_Project, :Time, :Done, :Log)");

        $result = $statement->execute(
          array(
            ':Fk_User' => $_POST["Ressource"],
            ':Fk_Project' => $_POST["Projet"],
            ':Time' => $_POST["Time"],
            ':Done' => $_POST["Done"],
            ':Log' => $_POST["Log"]
          )
        );
        if (!empty($result))
          echo '✓';
        else
          print_r($statement->errorInfo());
      }
      else echo 'Dépasse de ' , $result["Depasse"] - 1;
    };


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

    if ($_POST["action"] == "DiffFiche") {

      $array = [];
      //Requete liste pour chart fiche de temps pas a jour
      $statement = $connection->prepare(
        $sql = 
        "SELECT count(C.Done) as Nombre,
        CONCAT(E.prenom,' ', E.initial) AS User
        From cir C
        inner join employe E on C.Fk_User = E.id
        where Done not like Log
        group by Fk_User"
      );

      $statement->execute();
      $result = $statement->fetchAll();

      $Ressource = [];
      $NombreDiff = [];

      foreach ($result AS $row) {

        $Ressource[] = $row['User'];
        $NombreDiff[] = intval($row['Nombre']);

      }

      $array['LaRessourceFeuille'] = $Ressource;
      $array['LaDiffFeuil'] = $NombreDiff;
    
      echo json_encode($array);
    }

  }

  ?>
