   <?php

require_once ('../Modele/Configs.php');

   if(isset($_POST["action"])) 
   {

    if($_POST["action"] == "GetTotalADescendre")
    {

      $NumeroSprint = $_POST["NumeroSprint"];
      $statement = $connection->prepare(
       "SELECT sum(attribution.heure) as Total from attribution where attribution.id_Sprint = (Select sprint.id from sprint where sprint.numero = $NumeroSprint) AND attribution.id_TypeTache IS NULL"
     );
      $statement->execute();
      $result = $statement->fetch();
      echo $result["Total"];
    }

    if($_POST["action"] == "GetLesInfosDeLaBurnDownChart")
    {

      $NumeroSprint = $_POST["NumeroSprint"];

      $statement = $connection->prepare(
       $sql = "SELECT $NumeroSprint as sprint, burndownhour as value, date as heure, (SELECT sum(interference.heure)  FROM interference where interference.id_Sprint = ( SELECT sprint.id FROM sprint WHERE sprint.numero = $NumeroSprint )) as interferances FROM `vburndown`where id_Sprint = (SELECT sprint.id FROM sprint WHERE sprint.numero = $NumeroSprint) order by Date"

     );
      $statement->execute();
      $result = $statement->fetchAll();

      $values = [];
      $interferences = [];
      $sprintou = [];
      $ToutADescendre = [];

      foreach ($result as $row) {
       $values[] = $row['value'];

       if( empty($row['interferances'])  || is_null($row['interferances'])  || !isset($row['interferances']) || $row['interferances'] === NULL ){
        $interferences[] = 0;
       }
       else
       {
        $interferences[] = $row['interferances'];
       }

       $sprintou[] = $row['sprint'];
     }

     $array[] = $values;
     $array[] = $interferences;
     $array[] = $sprintou;

      $statement = $connection->prepare(
       "SELECT sum(attribution.heure) as Total from attribution where attribution.id_Sprint = (Select sprint.id from sprint where sprint.numero = $NumeroSprint) AND attribution.id_TypeTache IS NULL"
     );
      $statement->execute();
      $result = $statement->fetch();
      $ToutADescendre[] = $result["Total"];

      $array[] = $ToutADescendre;


      $statement = $connection->prepare( $sql = "SELECT * from sprint where sprint.numero = $NumeroSprint"     );
      $statement->execute();
      $result = $statement->fetch();

      $array[] = $result['dateDebut'];
      $array[] = $result['dateFin'];

}

   echo json_encode($array);

   }
   
 ?>
