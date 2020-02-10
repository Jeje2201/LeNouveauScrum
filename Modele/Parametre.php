   <?php
    session_start();
    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      $idRessource = $_SESSION['user']['id'];

      if ($_POST["action"] == "LoadTacheValide") {
        $output = array();
        $statement = $connection->prepare(
        "SELECT sum(tache_heure) as 'Temps',
        projet_nom
        FROM `tache`
        INNER JOIN projet on tache_fk_projet = projet_pk
        where tache_fk_user = " . $idRessource . "
        and tache_done is not null
        group by tache_fk_projet
        order by Temps desc");
        
        $statement->execute();
        $result = $statement->fetchAll();
        $output = '';
        $output .= '
        <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
        <thead class="thead-light">
        <tr>
        <th width="">Projet</th>
        <th width="">Total</th>
        </tr>
        </thead>
        <tbody id="myTable">
        ';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {

            $output .= '
            <tr>
            <td>' . $row["projet_nom"] . '</td>
            <td>' . $row["Temps"] . 'h</td>
            </tr>';
          }
        } else {
          $output .= '
          <tr>
            <td align="center" colspan="10">Pas de données</td>
          </tr>';
        }
        $output .= '</tbody></table>';
        print $output;
      }
    }

    ?> 