   <?php
    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "Projet_Changer_Avatar") {

        $target_file = basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $target_file = 'avatar_projet_'. $_POST["logo_project_id"] . '.'.$imageFileType;
        $pathDeLimage= "../Assets/Image/Projets/" . $target_file;

        if (file_exists($target_file)) {
          print "Ce nom d'image existe déjà. Changez le nom et recommencez.";
        }

        else if ($_FILES["image"]["size"] > 2000000) {
          print "Tu veux pas envoyer un fichier de la taille d'un film aussi ? Trouve plus petit (max = 2mo)";
        }

        else if (move_uploaded_file($_FILES["image"]["tmp_name"], $pathDeLimage)) {

          $statement = $connection->prepare(
            $sql = "SELECT P.avatar AS avatar
            FROM projet P
            WHERE P.id = " . $_POST["logo_project_id"]
          );
  
          $statement->execute();
          $result = $statement->fetch();

          //Si on a un résultat non null, c'est qu'une image existé avant et on la supprime, sinon on passe a autre chose
         if($result[0] != null){
            if (unlink("../Assets/Image/Projets/".$result[0])) {
              print "Suppression du précédent avatar réussi\n";
            } else {
               print "Impossible de supprimer l'image précédente ".$result[0]."\n";
            }
         }else{
            print "Aucune image précédente.\n";
         }

          $statement = $connection->prepare(
            $sql = "UPDATE projet P
            set P.avatar = '". $target_file ."'
            WHERE P.id = " . $_POST["logo_project_id"]
          );
  
          $statement->execute();

          move_uploaded_file($_FILES["image"]["tmp_name"], $pathDeLimage);

          print "Votre avatar a évolué, félicitation !";

        }
        else{
          print "Une erreur est survenu mais non reconnue.. L'image dépasse peut être 2mo ?";
        }
      }



    }

    ?> 