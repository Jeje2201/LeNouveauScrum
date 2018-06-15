   <?php

   $username = 'root';
   $password = '';
   $connection = new PDO( 'mysql:host=localhost;dbname=scrum', $username, $password ); 

   if(isset($_POST["action"])) 
   {


    if($_POST["action"] == "GetTotalADescendre")
{

  $NumeroSprint = $_POST["NumeroSprint"];
  $statement = $connection->prepare(
   "SELECT sum(attribution.heure) as Total from attribution where attribution.id_Sprint = (Select sprint.id from sprint where sprint.numero = $NumeroSprint)"
 );
  $statement->execute();
  $result = $statement->fetch();
  echo $result["Total"];
}

}

?>
