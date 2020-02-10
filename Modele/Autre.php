   <?php

    session_start();
    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      //Load les fiches de temps de tout le monde dans la gestion des fiches de temps
      if ($_POST["action"] == "UrgentNotification") {
        print $Urgent_Notification;
      }

      if ($_POST["action"] == "getApiPivotalKey") {
        print $PivotalKey;
      }
    }
    ?> 