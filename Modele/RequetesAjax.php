   <?php

  require_once('../Modele/Configs.php');

  if (isset($_POST["action"])) {

    $action = $_POST["action"];


    switch ($action) {

      case 'TableauDeSprint2':
        $statement = $connection->prepare("SELECT * FROM sprint
        ORDER BY numero DESC");
        $statement->execute();
        $result = $statement->fetchAll();
        if ($statement->rowCount() > 0) {
          foreach ($result AS $row) {

            $test["numero"] = $row["numero"];
            $test["dateDebut"] = $row["dateDebut"];
            $test["dateFin"] = $row["dateFin"];
            $test["id"] = $row["id"];

            echo json_encode($test);

          }

        }

        break;

      case 'ListeDeroulanteSprint':

        $statement = $connection->prepare("SELECT id AS id,
        numero AS numero
        FROM sprint
        ORDER BY numero DESC");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<select class="form-control"  id="numeroSprint" name="numeroSprint">';

        if ($statement->rowCount() > 0) {
          foreach ($result AS $row) {

            $output2 .= '<option value="' . $row["id"] . '"> ' . $row["numero"] . ' </option>';

          }

          $output2 .= '</select>';
        }

        echo $output2;

        break;

      case 'ListeDeroulanteProjet':

        $statement = $connection->prepare("SELECT id AS id,
        nom AS Nom
        FROM projet
        ORDER BY nom asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<select class="form-control"  id="projetId" name="projetId">';

        if ($statement->rowCount() > 0) {
          foreach ($result AS $row) {

            $output2 .= '<option value="' . $row["id"] . '"> ' . $row["Nom"] . ' </option>';

          }

          $output2 .= '</select>';
        }

        echo $output2;

        break;

        case 'ProjetPivotal':

        $statement = $connection->prepare("SELECT id,
        ApiPivotal,
        nom
        FROM projet
        WHERE ApiPivotal IS NOT NULL
        ORDER BY nom asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<select class="form-control"  id="ProjetApi" name="ProjetApi">';

        if ($statement->rowCount() > 0) {
          foreach ($result AS $row) {

            $output2 .= '<option value="' . $row["id"] . '|' . $row["ApiPivotal"] . '"> ' . $row["nom"] . ' </option>';

          }

          $output2 .= '</select>';
        }

        echo $output2;

        break;

        case 'RessourcePivotal':

        $statement = $connection->prepare("SELECT id,
        ApiPivotal,
        prenom,
        nom
        FROM employe
        WHERE actif = 1
        AND ApiPivotal IS NOT NULL
        ORDER BY prenom asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<select class="form-control"  id="RessourceApi" name="RessourceApi">';

        if ($statement->rowCount() > 0) {
          foreach ($result AS $row) {

            $output2 .= '<option value="' . $row["id"] . '|' . $row["ApiPivotal"] . '"> ' . $row["prenom"] . ' ' . $row["nom"] . ' </option>';

          }

          $output2 .= '</select>';
        }

        echo $output2;

        break;


      case 'ListeDeroulanteEmploye':

        $statement = $connection->prepare("SELECT id,
        prenom,
        nom
        FROM employe
        WHERE nom not like 'Rouleau'
        ORDER BY prenom asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<select class="form-control"  id="employeId" name="employeId">';

        if ($statement->rowCount() > 0) {
          foreach ($result AS $row) {

            $output2 .= '<option value="' . $row["id"] . '"> ' . $row["prenom"] . ' ' . $row["nom"] . ' </option>';

          }

          $output2 .= '</select>';
        }

        echo $output2;

        break;

      case 'ListeDeroulanteEmployeActifTrieParType':

        $statement = $connection->prepare("SELECT prenom,
        nom,
        id
        FROM employe E
        WHERE E.actif = 1
        ORDER BY prenom asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<select class="form-control"  id="TypeEmployeOk" name="TypeEmployeOk">';

        if ($statement->rowCount() > 0) {
          foreach ($result AS $row) {

            $output2 .= '<option value="' . $row["id"] . '"> ' . $row["prenom"] . ' ' . $row["nom"] . ' </option>';

          }

          $output2 .= '</select>';
        }

        echo $output2;

        break;

      case 'ListeDeroulanteTypeInterferance':

        $statement = $connection->prepare("SELECT id,
        nom
        FROM typeinterference
        ORDER BY id asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<select class="form-control"  id="typeinterference" name="typeinterference">';

        if ($statement->rowCount() > 0) {
          foreach ($result AS $row) {

            $output2 .= '<option value="' . $row["id"] . '">' . $row["nom"] . '</option>';

          }

          $output2 .= '</select>';
        }

        echo $output2;

        break;

      case 'ListeDeroulanteTypeEmploye':

        $statement = $connection->prepare("SELECT id,
        nom
        FROM typeemploye
        ORDER BY nom asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<select class="form-control"  id="TypeEmploye" name="TypeEmploye">';

        if ($statement->rowCount() > 0) {
          foreach ($result AS $row) {

            if ($row["nom"] == "Developpeur")
              $output2 .= '<option value="' . $row["id"] . '" selected> ' . $row["nom"] . ' </option>';
            else
              $output2 .= '<option value="' . $row["id"] . '"> ' . $row["nom"] . ' </option>';
          }

          $output2 .= '</select>';
        }

        echo $output2;

        break;

      case 'ListeDeroulanteTypeProjet':

        $statement = $connection->prepare("SELECT id,
        nom
        FROM typeprojet
        ORDER BY nom asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<select class="form-control"  id="TypeProjet" name="TypeProjet">';

        if ($statement->rowCount() > 0) {
          foreach ($result AS $row) {

            $output2 .= '<option value="' . $row["id"] . '"> ' . $row["nom"] . ' </option>';

          }

          $output2 .= '</select>';
        }

        echo $output2;

        break;

      case 'ListeDeroulanteEtatObjectif':

        $statement = $connection->prepare("SELECT id,
        nom
        FROM statutobjectif
        ORDER BY nom asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<form class="form-control" name="EtatObjectif" id="EtatObjectif">';

        if ($statement->rowCount() > 0) {
          foreach ($result AS $row) {

            $output2 .= '<label><input type="radio" name="Etat" id="EtatNum' . $row["id"] . '" value="' . $row["id"] . '">  ' . $row["nom"] . '</label><br>';

          }

          $output2 .= '</form>';
        }

        echo $output2;

        break;

      case 'ListEmployeCheckBox':

        $statement = $connection->prepare("SELECT id,
        prenom,
        nom
        FROM employe E
        WHERE E.actif = 1
        ORDER BY prenom asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<input type="checkbox" style="margin-left: 9px;" name="ListEmployeCheckBox1" id="TOUTLEMONDE" value="TOUTLEMONDE"> Tout le monde<hr>';
        if ($statement->rowCount() > 0) {
          foreach ($result AS $row) {

            $output2 .= '<input type="checkbox" class="checkbox" style="margin-left: 9px;" name="ListEmployeCheckBox1" id="ListEmployeCheckBox1" value="' . $row["id"] . '">  ' . $row["prenom"] . ' ' . $row["nom"] . '</br>';

          }

        }

        echo $output2;

        break;

      case 'RemplirTypeTache':

        $statement = $connection->prepare("SELECT id,
        nom,
        couleur
        FROM typetache
        ORDER BY nom asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<select class="form-control"  id="RemplirTypeTache1" name="RemplirTypeTache1">';

        if ($statement->rowCount() > 0) {
          foreach ($result AS $row) {

            $output2 .= '<option style="background-color:' . $row["couleur"] . '; color:black" value="' . $row["id"] . '"> ' . $row["nom"] . ' </option></br>';

          }

          $output2 .= '</select>';
        }

        echo $output2;

        break;

    }
  }
  ?>
