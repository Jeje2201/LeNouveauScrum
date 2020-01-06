   <?php
    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "DescriptionProjet") {
        $output = array();
        $statement = $connection->prepare(
          "SELECT * FROM projet 
         WHERE id = '" . $_POST["id"] . "' 
         LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetch();

        $output["Nom"] = $result["nom"];
        $output["Description"] = $result["description"];
        $output["Logo"] = $result["Id_Logo"];

        echo json_encode($output);
      }

      if ($_POST["action"] == "DescriptionClient") {
        $output = array();
        $statement = $connection->prepare(
          "SELECT * FROM clientprojet 
         WHERE id = (select id_client from projet where projet.id = '" . $_POST["id"] . "') 
         LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetch();

        $output["entreprise"] = $result["entreprise"];
        $output["Nom"] = $result["nom"];
        $output["job"] = $result["job"];
        $output["mail"] = $result["mail"];
        $output["telephone"] = $result["telephone"];

        echo json_encode($output);
      }
    }

    ?> 