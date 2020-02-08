   <?php
    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      if ($_POST["action"] == "Projet_Changer_Avatar") {
        $imageFileType = strtolower(pathinfo(basename($_FILES["image"]["name"]), PATHINFO_EXTENSION));
        $pathDeLimage= '../Assets/Image/Projets/avatar_projet_'. $_POST["logo_project_id"] . '.png';

        if($imageFileType == "png"){
          if (file_exists($pathDeLimage)) {
            unlink($pathDeLimage);
            print "Une image pour ce logo existait déjà, elle est supprimée.\n";
          }
          else{
            print "Aucune image connu pour se logo.\n";
          }

          move_uploaded_file($_FILES["image"]["tmp_name"], $pathDeLimage);

          print "Nouveau logo créé avec succès.";

        }
        else{
          print "L'image doit être un png.";
        }
      }

    }

    ?> 