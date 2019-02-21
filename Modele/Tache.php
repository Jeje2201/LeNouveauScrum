    <?php

    require_once('../Modele/Configs.php');

    //Si jamais le texte d'une tache risque de casser l'html qui ressort
    function PreviewText($input)
    {
      $Problem = array("<", ">");
      $input = str_replace($Problem, " ", $input);

      return $input;
    }

    if (isset($_POST["action"])) {

      //Fonction pour afficher les cards a descendre et descendues
      if ($_POST["action"] == "AfficherCards") {
        $Test = new stdClass;

        $idEmploye = $_POST["idEmploye"];
        $numero = $_POST["idAffiche"];

        if ($_POST["idEmploye"] == "ToutLeMonde")
          $Requete1 = "AND A.id_Employe in (select id from employe)";
        else
          $Requete1 = "AND A.id_Employe = $idEmploye";

        $statement = $connection->prepare("
          SELECT A.id, A.Label, A.heure, P.nom as projet, P.Logo, E.Initial, E.couleur, E.prenom as E_Prenom, E.nom as E_Nom, E.Pseudo as E_Pseudo
          FROM attribution A
          INNER JOIN employe E ON E.id = A.id_Employe
          INNER JOIN projet P ON P.id = A.id_Projet
          INNER JOIN sprint S ON S.id = A.id_Sprint
          where A.id_Sprint =  $numero
          and A.Done is null "  . $Requete1 .
          " ORDER BY E.prenom");

        $statement->execute();
        $result = $statement->fetchAll();
        $output1 = '';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {
            $output1 .= '
      <div class="card BOUGEMOI" id="' . $row["id"] . '" onclick="DeplaceToi(this)">
        <img class="LogoProjet" src="Assets/Image/Projets/' . $row["Logo"] . '">
        <div style="margin-left:7px;">
          <div class="BarreLateralCard" style="background-color:' . $row["couleur"] . ';"></div>
            <i class="fa fa-user-o" aria-hidden="true"></i> ' . $row["E_Pseudo"] . ' (' . $row["Initial"] . ')<br>
            <div class="SpecialHr"></div>
            <i class="fa fa-file-o" aria-hidden="true"></i> ' . $row["projet"] . '<br>
            <div class="SpecialHr"></div>
            <i class="fa fa-tag" aria-hidden="true"></i> ' . PreviewText($row["Label"]) . ' (' . $row["heure"] . ')
        </div>
      </div>';
          }
        } else {
          $output1 .= 'Pas de tâche';
        }

        $statement = $connection->prepare("SELECT A.id, A.Label, A.heure, P.nom as projet, P.Logo, E.Initial, E.couleur, E.prenom, E.nom as E_Nom, E.Pseudo
        FROM attribution A
        INNER JOIN employe E ON E.id = A.id_Employe
        INNER JOIN projet P ON P.id = A.id_Projet
        INNER JOIN sprint S ON S.id = A.id_Sprint
        where A.id_Sprint =  $numero
        and A.Done is not null "  . $Requete1 .
          " ORDER BY E.prenom");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {

            $output2 .= '
<div class="card PASTOUCHE">
  <img class="LogoProjet" src="Assets/Image/Projets/' . $row["Logo"] . '">
  <div style="margin-left:7px;">
    <div class="BarreLateralCard" style="background-color:' . $row["couleur"] . ';"></div>
      <i class="fa fa-user-o" aria-hidden="true"></i> ' . $row["Pseudo"] . ' (' . $row["Initial"] . ')<br>
      <div class="SpecialHr"></div>
      <i class="fa fa-file-o" aria-hidden="true"></i> ' . $row["projet"] . '<br>
      <div class="SpecialHr"></div>
      <i class="fa fa-tag" aria-hidden="true"></i> ' . PreviewText($row["Label"]) . ' (' . $row["heure"] . ')
  </div>
</div>';

          }
        } else {
          $output2 .= 'Pas de tâche';
        }
        $Test->Attribution = $output1;
        $Test->Descendue = $output2;

        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');

        echo json_encode($Test);

      }

      //Afficher la liste d'employes qui ont des taches
      if ($_POST["action"] == "LoadListEmployes") {
        $Test = new stdClass;

        $numero = $_POST["idAffiche"];

        $statement = $connection->prepare("
  SELECT DISTINCT (select employe.prenom from employe where employe.id = attribution.id_Employe) as Prenom, (select employe.nom from employe where employe.id = attribution.id_Employe) as Nom, attribution.id_Employe as id
  FROM attribution
  where attribution.id_Sprint = $numero
  order by (select employe.prenom from employe where employe.id = attribution.id_Employe)
  ");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<select class="form-control"  id="numeroEmploye" name="numeroEmploye">
              <option value="ToutLeMonde">Tout le monde</option>';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {

            $output2 .= '<option value="' . $row["id"] . '"> ' . $row["Prenom"] . ' ' . $row["Nom"] . ' </option>';

          }

          $output2 .= '</select>';
        }
        $Test->Attribution = $output2;

        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');

        echo json_encode($Test);

      }

      //Ressortir la date min et max du sprint
      if ($_POST["action"] == "DateMinMax") {

        $idAffiche = $_POST["idAffiche"];

        $statement = $connection->prepare(
          $sql = "SELECT `dateDebut` as DateMin, `dateFin` as DateMax from sprint where sprint.id = $idAffiche"
        );
        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {
          $DateMin[] = date("d-m-Y", strtotime($row["DateMin"]));
          $DateMax[] = date("d-m-Y", strtotime($row["DateMax"]));
        }

        $array['DateMin'] = $DateMin;
        $array['DateMax'] = $DateMax;

        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode($array);

      }

      //Valider une tache, soit lui donner une date de validation
      if ($_POST["action"] == "Descendre") {

        $IdAttribue = $_POST["IdAttribue"];

        for ($i = 0; $i < sizeof($IdAttribue); $i++) {

          $statement = $connection->prepare("UPDATE attribution
          set Done = :done
          where id = :id");

          $result = $statement->execute(
            array(
              ':done' => $_POST["LeJourDeDescente"],
              ':id' => $IdAttribue[$i]
            )
          );
        }
        if (!empty($result))
          echo '✓';
        else
          print_r($statement->errorInfo());
      }

    }

    ?>
