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
       $sql = "SELECT $NumeroSprint as sprint, burndownhour as Heures, date as Jours, (SELECT sum(interference.heure)  FROM interference where interference.id_Sprint = ( SELECT sprint.id FROM sprint WHERE sprint.numero = $NumeroSprint )) as interferances FROM `vburndown`where id_Sprint = (SELECT sprint.id FROM sprint WHERE sprint.numero = $NumeroSprint) order by Date"
     );
      $statement->execute();
      $result = $statement->fetchAll();

      foreach ($result as $row) {
       $Heures[] = $row['Heures'];

        $interferences[] = $row['interferances'];

       $sprintou[] = $row['sprint'];
       $Jours[] = date("d-m-Y", strtotime($row['Jours']));
     }

     $array['HeuresDesJours'] = $Heures;
     $array['Interference'] = $interferences;
     $array['NumeroSprint'] = $sprintou;

      $statement = $connection->prepare(
       "SELECT sum(attribution.heure) as Total from attribution where attribution.id_Sprint = (Select sprint.id from sprint where sprint.numero = $NumeroSprint) AND attribution.id_TypeTache IS NULL"
     );
      $statement->execute();
      $result = $statement->fetch();
      $ToutADescendre[] = $result["Total"];

      $array['TotalADescendre'] = $ToutADescendre;

$statement = $connection->prepare( $sql = "SELECT * from sprint where sprint.numero = $NumeroSprint"     );
      $statement->execute();
      $result = $statement->fetch();

      $array['DateDebut'] = $result['dateDebut'];
      $array['DateFin'] = $result['dateFin'];
      $array['JoursAvecDesHeures'] = $Jours;
      

}

   echo json_encode($array);

   }
   
 ?>
