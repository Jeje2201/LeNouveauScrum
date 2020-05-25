   <?php

    session_start();
    require_once('Configs.php');

    if (isset($_POST["action"])) {

      //Load les fiches de temps de tout le monde dans la gestion des fiches de temps
      if ($_POST["action"] == "UrgentNotification") {
        $objet = [];
        $objet['Message'] = $Urgent_Notification[0];
        $objet['Type'] = $Urgent_Notification[1];
        print json_encode($objet);
      }

      if ($_POST["action"] == "getApiPivotalKey") {
        print $PivotalKey;
      }

      if ($_POST["action"] == "getEnvStatue") {
        print json_encode($Env_Prod);
      }
    }
    ?> 