   <?php

   $username = 'root';
   $password = '';
   $connection = new PDO( 'mysql:host=localhost;dbname=scrum', $username, $password ); 

   if(isset($_POST["action"])) 
   {

    if($_POST["action"] == "GetTotalHeuresDescenduesParEmploye")
    {

      $NumeroduSprint = $_POST["NumeroduSprint"];

      $statement = $connection->prepare(
       $sql = "SELECT (select employe.prenom from employe where employe.id= heuresdescendues.id_Employe) as employe,
sum(heuresdescendues.heure) as HDescendue,
(select sum(attribution.heure) from attribution where attribution.id_Employe= employe.id and attribution.id_Sprint = $NumeroduSprint) as Hattribue
FROM `heuresdescendues` INNER JOIN employe on heuresdescendues.id_Employe = employe.id
where id_Sprint = $NumeroduSprint  group by heuresdescendues.id_Employe ORDER BY HDescendue desc"
     );

      $statement->execute();
      $result = $statement->fetchAll();

      foreach ($result as $row) {

       $employe[] = $row['employe'];
       $HDescendue[] = intval($row['HDescendue']);
       $Hattribue[] = intval($row['Hattribue']);
       
     }

     $array[] = $employe;
     $array[] = $HDescendue;
     $array[] = $Hattribue;


           $statement = $connection->prepare(
       $sql = "SELECT (select projet.nom from projet where projet.id= heuresdescendues.id_Projet) as projet,
sum(heuresdescendues.heure) as HDescendue,
(select sum(attribution.heure) from attribution where attribution.id_Projet= projet.id and attribution.id_Sprint = $NumeroduSprint) as Hattribue
FROM `heuresdescendues` INNER JOIN projet on heuresdescendues.id_Projet = projet.id
where id_Sprint = $NumeroduSprint  group by heuresdescendues.id_Projet ORDER BY HDescendue desc"
     );
      
      $statement->execute();
      $result = $statement->fetchAll();

      foreach ($result as $row) {

       $projet[] = $row['projet'];
       $HDescendueProjet[] = intval($row['HDescendue']);
       $HattribueProjet[] = intval($row['Hattribue']);
       
     }

     $array[] = $projet;
     $array[] = $HDescendueProjet;
     $array[] = $HattribueProjet;

    }

   echo json_encode($array);

   }
   
 ?>
