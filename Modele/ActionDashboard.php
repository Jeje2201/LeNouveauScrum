   <?php

   $username = 'root';
   $password = '';
   $connection = new PDO( 'mysql:host=localhost;dbname=scrum', $username, $password ); 

   if(isset($_POST["action"])) 
   {

    if($_POST["action"] == "GetTotalHeuresDescenduesParEmploye")
    {

      $statement = $connection->prepare(
       $sql = "SELECT (select employe.prenom from employe where employe.id= heuresdescendues.id_Employe) as employe ,sum(heuresdescendues.heure) as HDescendue FROM `heuresdescendues` where id_Sprint = 1 and id_Employe NOT IN (select id from employe where employe.nom = 'Groupe') group by heuresdescendues.id_Employe ORDER BY HDescendue desc"

     );
      $statement->execute();
      $result = $statement->fetchAll();

      $employe = [];
      $HDescendue = [];

      foreach ($result as $row) {

       $employe[] = $row['employe'];
       $HDescendue[] = intval($row['HDescendue']);
       
     }
     $array[] = $employe;
     $array[] = $HDescendue;

    }

   echo json_encode($array);

   }
   
 ?>
