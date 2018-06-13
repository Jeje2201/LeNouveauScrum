   <?php

   $username = 'root';
   $password = '';
   $connection = new PDO( 'mysql:host=localhost;dbname=scrum', $username, $password ); 

   if(isset($_POST["action"])) 
   {

     if($_POST["action"] == "Load") 
     {
      $Test = new stdClass;

      $idEmploye = $_POST["idEmploye"];
      $numero = $_POST["idAffiche"];

      $statement = $connection->prepare("SELECT attribution.id, attribution.heure as NbHeure, projet.nom as projet, employe.prenom as employe FROM attribution inner JOIN employe ON employe.id = attribution.id_Employe INNER JOIN projet ON projet.id = attribution.id_Projet INNER JOIN sprint ON sprint.id = attribution.id_Sprint where attribution.id_Sprint = $numero AND id_Employe = $idEmploye ORDER BY attribution.id DESC");

      $statement->execute();
      $result = $statement->fetchAll();
      $output1 = '';
      if($statement->rowCount() > 0)
      {
       foreach($result as $row)
       {

$output1.='<div class="card bg-light">
      <div class="card-body text-center">
        <p class="card-text">'.$row["employe"].' | '.$row["projet"].' | <b>'.$row["NbHeure"].'h</b></p>
        <input style="display: none" class="lavaleur" value="'.$row["id"].'" />
        <button style="display: none" onclick="GoTop(this)">Annuler</button>
        <button onclick="GoDown(this)">Achevée</button>
      </div>
    </div>';

      }
    }

   $Test -> Attribution = $output1;

$statement = $connection->prepare("SELECT heuresdescendues.id as id, heuresdescendues.heure as NbHeure, heuresdescendues.DateDescendu as Datee, projet.nom as projet, employe.prenom as employe FROM heuresdescendues inner JOIN employe ON heuresdescendues.id_Employe = employe.id INNER JOIN projet on projet.id = heuresdescendues.id_Projet INNER JOIN sprint on sprint.id = heuresdescendues.id_Sprint WHERE id_sprint= $numero AND id_Employe = $idEmploye ORDER BY heuresdescendues.id desc");

      $statement->execute();
      $result = $statement->fetchAll();
      $output2 = '';
      if($statement->rowCount() > 0)
      {
       foreach($result as $row)
       {

$output2.='<div class="card bg-light">
      <div class="card-body text-center">
        <p class="card-text">'.$row["employe"].' | '.$row["projet"].' | <b>'.$row["NbHeure"].'h</b></p>
        <input style="display: none" class="lavaleur" value="'.$row["id"].'" />
        <button onclick="GoTop(this)">Annuler</button>
        <button style="display: none" onclick="GoDown(this)">Achevée</button>
      </div>
    </div>';

      }
    }
      $Test -> Descendue = $output2;

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

   echo json_encode($Test);


 }

 if($_POST["action"] == "Valider")
 {
  $statement = $connection->prepare("
   INSERT INTO heuresdescendues (heure, DateDescendu, id_Sprint, id_Employe, id_Projet) 
   VALUES (:NombreHeure, :DateDescendu, :idSprint, :idEmploye, :idProjet)
   ");
  $result = $statement->execute(
   array(
    ':NombreHeure' => $_POST["NombreHeure"],
    ':DateDescendu' => $_POST["DateAujourdhui"],
    ':idSprint' => $_POST["idSprint"],
    ':idEmploye' => $_POST["idEmploye"],
    ':idProjet' => $_POST["idProjet"]
  )
 );
  if(!empty($result))
  {
   echo 'Heure(s) Descendue(s) ! 😄';
 }

}

if($_POST["action"] == "Select")
{
  $output = array();
  $statement = $connection->prepare(
   "SELECT * FROM heuresdescendues 
   WHERE id = '".$_POST["id"]."' 
   LIMIT 1"
 );
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
   $output["heure"] = $row["heure"];
   $output["DateAujourdhui"] = $row["DateDescendu"];
   $output["id_Employe"] = $row["id_Employe"];
   $output["id_Projet"] = $row["id_Projet"];
 }
 echo json_encode($output);
}

if($_POST["action"] == "Update")
{
  $statement = $connection->prepare(
   "UPDATE heuresdescendues
   SET heure = :heure, id_Sprint = :id_Sprint, id_Projet = :id_Projet, DateDescendu = :DateDescendu, id_Employe = :id_Employe 
   WHERE id = :id
   "
 );
  $result = $statement->execute(
   array(
    ':heure' => $_POST["NombreHeure"],
    ':DateDescendu' => $_POST["DateAujourdhui"],
    ':id_Sprint' => $_POST["idSprint"],
    ':id_Projet' => $_POST["idProjet"],
    ':id_Employe'   => $_POST["idEmploye"],
    ':id'   => $_POST["id"]
  )
 );
  if(!empty($result))
  {
   echo 'Heure(s) descendue(s) modifiée(s) ! 😮';
 }
}

if($_POST["action"] == "Delete")
{
  $statement = $connection->prepare(
   "DELETE FROM heuresdescendues WHERE id = :id"
 );
  $result = $statement->execute(
   array(
    ':id' => $_POST["id"]
  )
 );
  if(!empty($result))
  {
   echo 'Heure(s) descendue(s) supprimée(s) ! 😢';
 }
}

}

?>
