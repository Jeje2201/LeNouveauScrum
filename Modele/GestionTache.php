   <?php

require_once('Configs.php');

    if (isset($_POST["action"])) {

      //Get les information d'une tache
      if ($_POST["action"] == "Select") {
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

      //Mettre a jour une tache
      if ($_POST["action"] == "Update") {

        if ($_POST["Done"] == "")
          $_POST["Done"] = null;

        $statement = $connection->prepare(
          "UPDATE tache
          SET tache_heure = :heure, tache_fk_sprint = :id_Sprint, tache_fk_projet = :id_Projet, tache_done = :Done, tache_label = :Label, tache_fk_user = :id_Employe 
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

      if ($_POST["action"] == "Delete") {
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
    }

    ?> 