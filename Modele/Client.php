   <?php

    require_once('Configs.php');

    if (isset($_POST["action"])) {

      //Get all
      if ($_POST["action"] == "GetClients") {
        try {
          $statement = $connection->prepare(
            "SELECT *
            FROM client
            ORDER BY client_prenom asc"
          );
          $statement->execute();
          $result = $statement->fetchAll(PDO::FETCH_ASSOC);
          print json_encode($result);
        } catch (PDOException $e) {
          header($_SERVER["SERVER_PROTOCOL"] . ' 400 ' . utf8_decode($e->getMessage()));
        }
      }

      //Delete
      if ($_POST["action"] == "DellClient") {
        try {
          $statement = $connection->prepare(
            "DELETE FROM client
            WHERE client_pk = :id_client"
          );
          $result = $statement->execute(
            array(
              ':id_client' => $_POST["id_Client"]
            )
          );
          print "Client supprimé";
        } catch (PDOException $e) {
          header($_SERVER["SERVER_PROTOCOL"] . ' 400 ' . utf8_decode($e->getMessage()));
        }
      }

      //Get 1
      if ($_POST["action"] == "getUnClient") {
        try {
          $statement = $connection->prepare(
            "SELECT *
          FROM client
          WHERE client_pk = " . $_POST["client_pk"]
          );
          $statement->execute();
          $result = $statement->fetch(PDO::FETCH_ASSOC);

          print json_encode($result);
        } catch (PDOException $e) {
          header($_SERVER["SERVER_PROTOCOL"] . ' 400 ' . utf8_decode($e->getMessage()));
        }
      }

      //Creer
      if ($_POST["action"] == "CreerClient") {
        try {
          $statement = $connection->prepare(
            "INSERT INTO client (
              client_entreprise,
              client_prenom,
              client_nom,
              client_job,
              client_mail,
              client_telephone) 
            VALUES (
              :client_entreprise,
              :client_prenom,
              :client_nom,
              :client_job,
              :client_mail,
              :client_telephone)"
          );
          $result = $statement->execute(
            array(
              ':client_entreprise' => $_POST["client_entreprise"],
              ':client_prenom' => $_POST["client_prenom"],
              ':client_nom' => $_POST["client_nom"],
              ':client_job' => $_POST["client_job"],
              ':client_mail' => $_POST["client_mail"],
              ':client_telephone' => $_POST["client_telephone"]
            )
          );
          print "Nouveau client";
        } catch (PDOException $e) {
          header($_SERVER["SERVER_PROTOCOL"] . ' 400 ' . utf8_decode($e->getMessage()));
        }
      }

      //Edit 1
      if ($_POST["action"] == "EditerClient") {
        try {
          $statement = $connection->prepare(
            "UPDATE client 
          SET client_entreprise = :client_entreprise,
          client_prenom = :client_prenom,
          client_nom = :client_nom,
          client_job = :client_job,
          client_mail = :client_mail,
          client_telephone = :client_telephone
          WHERE client_pk = :client_pk"
          );
          $result = $statement->execute(
            array(
              ':client_entreprise' => $_POST["client_entreprise"],
              ':client_prenom' => $_POST["client_prenom"],
              ':client_nom' => $_POST["client_nom"],
              ':client_job' => $_POST["client_job"],
              ':client_mail' => $_POST["client_mail"],
              ':client_telephone' => $_POST["client_telephone"],
              ':client_pk' => $_POST["client_pk"]
            )
          );
          print "Client édité";
        } catch (PDOException $e) {
          header($_SERVER["SERVER_PROTOCOL"] . ' 400 ' . utf8_decode($e->getMessage()));
        }
      }

    }

    ?> 