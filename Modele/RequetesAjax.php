   <?php

    require_once('Configs.php');

    if (isset($_POST["action"])) {

      $action = $_POST["action"];

      switch ($action) {

        case 'ListeDeroulanteSprint':

          $statement = $connection->prepare("SELECT
          sprint_pk,
          sprint_numero
        FROM sprint
        ORDER BY sprint_numero DESC");

          $statement->execute();
          $result = $statement->fetchAll();
          $output2 = '<select class="form-control"  id="numeroSprint" >';

          if ($statement->rowCount() > 0) {
            foreach ($result as $row) {

              $output2 .= '<option value="' . $row["sprint_pk"] . '"> ' . $row["sprint_numero"] . ' </option>';
            }

            $output2 .= '</select>';
          }

          print $output2;

          break;

          /////////////////////////////////////

        case 'ListeDeroulanteProjet':

          $statement = $connection->prepare("SELECT *
          FROM projet
          where projet_type not like 'CIR'
          and projet_actif > 0
          ORDER BY projet_nom asc");

          $statement->execute();
          $result = $statement->fetchAll();
          $output2 = '<select class="form-control"  id="'.$_POST["id"].'" >';

          if ($statement->rowCount() > 0) {
            foreach ($result as $row) {
              $output2 .= '<option value="' . $row["projet_pk"] . '"> ' . $row["projet_nom"] . ' </option>';
            }

            $output2 .= '</select>';
          }

          print $output2;

          break;

          /////////////////////////////////////

        case 'ListeDeroulanteProjetAvecCir':

        $statement = $connection->prepare("SELECT *
        FROM projet
        WHERE projet_actif > 0
        ORDER BY projet_nom asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<select class="form-control"  id="projetId" >';

        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {

            $output2 .= '<option value="' . $row["projet_pk"] . '"> ' . $row["projet_nom"] . ' </option>';
          }

          $output2 .= '</select>';
        }

        print $output2;

        break;

          /////////////////////////////////////

        case 'ProjetPivotal':

          $statement = $connection->prepare("SELECT *
          FROM projet
          where projet_type not like 'CIR'
          and projet_actif = 2
          ORDER BY projet_nom asc");

          $statement->execute();
          $result = $statement->fetchAll();
          $output2 = '<select class="form-control"  id="ProjetApi" >';

          if ($statement->rowCount() > 0) {
            foreach ($result as $row) {

              $output2 .= '<option value="' . $row["projet_pk"] . '|' . $row["projet_apiPivotal"] . '"> ' . $row["projet_nom"] . ' </option>';
            }

            $output2 .= '</select>';
          }

          print $output2;

          break;

          /////////////////////////////////////

        case 'RessourcePivotal':

          $statement = $connection->prepare("SELECT *
        FROM user
        WHERE user_actif = 1
        AND user_apiPivotal IS NOT NULL
        ORDER BY user_prenom asc");

          $statement->execute();
          $result = $statement->fetchAll();
          $output2 = '<select class="form-control"  id="RessourceApi" >';

          if ($statement->rowCount() > 0) {
            foreach ($result as $row) {

              $output2 .= '<option value="' . $row["user_pk"] . '|' . $row["user_apiPivotal"] . '"> ' . $row["user_prenom"] . ' ' . $row["user_nom"] . ' </option>';
            }

            $output2 .= '</select>';
          }

          print $output2;

          break;

          /////////////////////////////////////

        case 'ListeDeroulanteEmploye':

          $statement = $connection->prepare("SELECT *
        FROM user
        WHERE user_nom not like 'Rouleau'
        ORDER BY user_prenom asc");

          $statement->execute();
          $result = $statement->fetchAll();
          $output2 = '<select class="form-control"  id="employeId" >';

          if ($statement->rowCount() > 0) {
            foreach ($result as $row) {

              $output2 .= '<option value="' . $row["user_pk"] . '"> ' . $row["user_prenom"] . ' ' . $row["user_nom"] . ' </option>';
            }

            $output2 .= '</select>';
          }

          print $output2;

          break;

          /////////////////////////////////////

        case 'ListeDeroulanteEmployeActif':

          $statement = $connection->prepare("SELECT *
        FROM user
        WHERE user_actif = 1
        ORDER BY user_prenom asc");

          $statement->execute();
          $result = $statement->fetchAll();
          $output2 = '<select class="form-control"  id="'.$_POST["id"].'" >';

          if ($statement->rowCount() > 0) {
            foreach ($result as $row) {

              $output2 .= '<option value="' . $row["user_pk"] . '"> ' . $row["user_prenom"] . ' ' . $row["user_nom"] . ' </option>';
            }

            $output2 .= '</select>';
          }

          print $output2;

          break;

          /////////////////////////////////////

        case 'ListeDeroulanteTypeProjet':

          $statement = $connection->prepare("SELECT distinct(projet_type)
        FROM projet
        ORDER BY projet_type asc");

          $statement->execute();
          $result = $statement->fetchAll();
          $output2 = '<select class="form-control"  id="TypeProjet" >';

          if ($statement->rowCount() > 0) {
            foreach ($result as $row) {

              $output2 .= '<option value="' . $row["projet_type"] . '"> ' . $row["projet_type"] . ' </option>';
            }

            $output2 .= '</select>';
          }

          print $output2;

          break;

          /////////////////////////////////////

        case 'ListEmployeCheckBox':

          $statement = $connection->prepare("SELECT *
        FROM user
        WHERE user_actif = 1
        ORDER BY user_prenom asc");

          $statement->execute();
          $result = $statement->fetchAll();
          $output2 = '<select name="states[]" multiple="multiple" id="TOUTLEMONDE" value="TOUTLEMONDE">';
          if ($statement->rowCount() > 0) {
            foreach ($result as $row) {
              $output2 .= '<option value="' . $row["user_pk"] . '">  ' . $row["user_prenom"] . ' ' . $row["user_nom"] . '</br>';
            }
          }
          $output2 .= '</select>';

          print $output2;
          break;

          /////////////////////////////////////

        case 'RemplirTypeTache':

          $statement = $connection->prepare("SELECT distinct(tache_type)
        FROM tache
        where tache_type is not null
        ORDER BY tache_type asc");

          $statement->execute();
          $result = $statement->fetchAll();
          $output2 = '<select class="form-control"  id="RemplirTypeTache1" name="RemplirTypeTache1">';

          if ($statement->rowCount() > 0) {
            foreach ($result as $row) {

              $output2 .= '<option value="' . $row["tache_type"] . '"> ' . $row["tache_type"] . ' </option></br>';
            }

            $output2 .= '</select>';
          }

          print $output2;

          break;
      }
    }
    ?> 