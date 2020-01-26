   <?php

    session_start();
    require_once('../Modele/Configs.php');

    if (isset($_POST["action"])) {

      //Load les fiches de temps de tout le monde dans la gestion des fiches de temps
      if ($_POST["action"] == "Trophee") {
        $Liste = [];

        $statement = $connection->prepare("SELECT if((SELECT sum(Time)/444 from fiche_de_temps where Fk_User = ".$_SESSION['IdUtilisateur']." AND Fk_Project = ( select id from projet where projet.nom like 'Congés'))>4 , '1', '0') as resultat
        union all
        /* Plus travailler temps sur un projet > 4*/
        select if((SELECT round(sum(Time)/444) as toto from fiche_de_temps where Fk_User = ".$_SESSION['IdUtilisateur']." GROUP BY Fk_Project order by toto desc limit 1)>48 , '1', '0')
        union all
        /* Avoir plus de 50 dobjectif ok */
        select if((select count(id_Employe) as total from retrospective_objectif where id_Employe = ".$_SESSION['IdUtilisateur']." AND id_StatutObjectif = (select id from statutobjectif where statutobjectif.nom = 'OK'))>50 , '1', '0')
        union all
        /* Avoir plus de 30h interferebce 1 sprint ok */
        select if((SELECT sum(heure) as total FROM `interference` where id_Employe = ".$_SESSION['IdUtilisateur']." GROUP BY id_Sprint, id_Employe order by total desc limit 1)>=30 , '1', '0')
        union all
        /* Avoir plus de 100 taches validées */
        select if((SELECT count(attribution.id) as Total FROM `attribution` where id_Employe = ".$_SESSION['IdUtilisateur']." AND Done is not null group by id_Projet order by Total desc limit 1)>=100 , '1', '0')");

        $statement->execute();
        $result = $statement->fetchAll();
        if ($statement->rowCount() > 0) {
          foreach ($result as $row) {
            $Liste[] = $row['resultat'];
          }
          print json_encode($Liste);
        }
      }

    }
    ?> 