   <?php
    session_start();
    require_once('Configs.php');

    if (isset($_POST["action"])) {

      // $idRessource = $_SESSION['user']['id'];

      if ($_POST["action"] == "LoadTacheValide") {
        $output = array();
        $statement = $connection->prepare(
        "SELECT sum(tache_heure) as 'Temps',
        projet_nom
        FROM `tache`
        INNER JOIN projet on tache_fk_projet = projet_pk
        where tache_fk_user = " . $_SESSION['user']['id'] . "
        and tache_done is not null
        group by tache_fk_projet
        order by Temps desc");
        
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        print json_encode($result);
      }
    }

    ?> 