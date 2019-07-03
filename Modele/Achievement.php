   <?php

    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      //Load les fiches de temps de tout le monde dans la gestion des fiches de temps
      if ($_POST["action"] == "Trophee") {
        $idRessource = $_POST["idRessource"];
        $Liste = [];

        $statement = $connection->prepare("SELECT if((SELECT sum(Time)/444 from cir where Fk_User = 22 and Fk_Project = ( select id from projet where projet.nom like 'Congés'))>4 , '1', '0') as resultat
        union all
        /* Plus travailler temps sur un projet > 4*/
        select if((SELECT round(sum(Time)/444) as toto from cir where Fk_User = 22 group by Fk_Project order by toto desc limit 1)>48 , '1', '0')
        union all
        /* Avoir plus de 50 dobjectif ok */
        select if((select count(id_Employe) as total from objectif where id_Employe = 22 and id_StatutObjectif = (select id from statutobjectif where statutobjectif.nom = 'OK'))>50 , '1', '0')
        union all
        /* Avoir plus de 30h interferebce 1 sprint ok */
        select if((SELECT sum(heure) as total FROM `interference` where id_Employe = 22 group by id_Sprint, id_Employe order by total desc limit 1)>=29 , '1', '0')");
        
        $statement->execute();
        $result = $statement->fetchAll();
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {
            $Liste[] = $row['resultat'];
          }
          echo json_encode($Liste);
        }
      }

      if ($_POST["action"] == "LeaderboardConge") {
        $statement = $connection->prepare("SELECT sum(Time)/444 as Total, E.prenom as Employe from cir C inner join employe E on E.id = C.Fk_User where Fk_Project = ( select id from projet where projet.nom like 'Congés') group by C.Fk_User order by Total desc limit 5");

        $statement->execute();
        $result = $statement->fetchAll();
        $output = '';
        $output .= '
        <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0"><thead class="thead-light"><tr><th colspan="10">Jours de congés</th></tr></thead><tbody id="myTable">';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {
            $output .= '
            <tr>
            <td>' . $row["Total"] . '</td>
            <td>' . $row["Employe"] . '</td>
            </tr>';
          }
        } else {
            $output .= '
            <tr><td align="center" colspan="10">Pas de données</td></tr>';
        }
        $output .= '</tbody></table>';
        echo $output;
      }

      if ($_POST["action"] == "LeaderboardObjectif") {
        $statement = $connection->prepare("SELECT count(id_Employe) as Total, E.prenom as Employe from objectif O INNER join employe E on O.id_Employe = E.id where id_StatutObjectif = (select id from statutobjectif where statutobjectif.nom = 'OK') and id_Employe != 45 group by id_Employe  
        ORDER BY `total`  DESC limit 5");

        $statement->execute();
        $result = $statement->fetchAll();
        $output = '';
        $output .= '
        <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0"><thead class="thead-light"><tr><th colspan="10">Objectifs "OK"</th></tr></thead><tbody id="myTable">';
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {
            $output .= '
            <tr>
            <td>' . $row["Total"] . '</td>
            <td>' . $row["Employe"] . '</td>
            </tr>';
          }
        } else {
            $output .= '
            <tr><td align="center" colspan="10">Pas de données</td></tr>';
        }
        $output .= '</tbody></table>';
        echo $output;
      }
    }
    ?> 