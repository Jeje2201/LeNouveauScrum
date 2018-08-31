   <?php
  require_once('../Modele/Configs.php');

  if (isset($_POST["action"])) {

    if ($_POST["action"] == "Load") {

      $array = [];
      $idRessource = $_POST["idRessource"];

      $statement = $connection->prepare(
        $sql = "SELECT Couleur, Pseudo FROM employe where employe.id = $idRessource"
      );
      $statement->execute();
      $result = $statement->fetch();
      echo " ";
      echo $result["Couleur"];
      echo " ";
      echo $result["Pseudo"];

    }

    if ($_POST["action"] == "Update") {
      $statement = $connection->prepare(
        "UPDATE employe 
   SET Pseudo = :Pseudo, Couleur = :Couleur
   WHERE id = :id
   "
      );
      $result = $statement->execute(
        array(
          ':Pseudo' => $_POST["Pseudo"],
          ':Couleur' => $_POST["couleur"],
          ':id' => $_POST["idRessource"]
        )
      );
      if (!empty($result))
        echo '✓';
      else
        echo 'X';
    }
  }

  ?>
