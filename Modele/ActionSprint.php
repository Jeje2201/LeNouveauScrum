   <?php

require_once ('../Modele/Configs.php');

  if(isset($_POST["action"]))   {
    if($_POST["action"] == "Load") 
   {
    $statement = $connection->prepare("SELECT * FROM sprint ORDER BY numero desc");
    $statement->execute();
    $result = $statement->fetchAll();
    $output = '';
    $output .= '
    <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
    <thead>
    <tr>
    <th width="30%">Numéro</th>
    <th width="30%">Début</th>
    <th width="30%">Fin</th>
    <th width="10%"><center>Éditer</center></th>
    </tr>
    </thead>
    <tbody id="myTable">
    ';
    if($statement->rowCount() > 0)
    {
     foreach($result as $row)
     {
       $output .= '
       <tr>
       <td>'.$row["numero"].'</td>
       <td>'.$row["dateDebut"].'</td>
       <td>'.$row["dateFin"].'</td>
       <td><center><div class="btn-group" role="group" aria-label="Basic example"><button type="button" id="'.$row["id"].'" class="btn btn-warning update"><i class="fa fa-pencil" aria-hidden="true"></i></button><button type="button" id="'.$row["id"].'" class="btn btn-danger delete"><i class="fa fa-times" aria-hidden="true"></i></button></div></center></td>
       </tr>
       ';
     }
   }
   else
   {
     $output .= '
     <tr>
     <td align="center">💩</td>
     </tr>
     ';
   }
   $output .= '</tbody></table>';
   echo $output;
 }

  if($_POST["action"] == "Créer")
 {
  $statement = $connection->prepare("
   INSERT INTO sprint (numero, dateDebut, dateFin) 
   VALUES (:numero, :dateDebut, :dateFin)
   ");
  $result = $statement->execute(
   array(
    ':numero' => $_POST["numero"],
    ':dateDebut' => $_POST["dateDebut"],
    ':dateFin' => $_POST["dateFin"]
  )
 );
  if(!empty($result))
  {
   echo 'Sprint créé ! 😄';
 }
}
 if($_POST["action"] == "SprintMax")
{
  $output = '';
  $statement = $connection->prepare(
   "SELECT Max(numero)+1 as numero FROM sprint"
 );
  $statement->execute();
  $result = $statement->fetch();
  if(isset($result["numero"]))
  echo $result["numero"];
else
  echo 1;
}

 if($_POST["action"] == "Select")
{
  $output = array();
  $statement = $connection->prepare(
   "SELECT * FROM sprint 
   WHERE id = '".$_POST["id"]."' 
   LIMIT 1"
 );
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
   $output["numero"] = $row["numero"];
   $output["dateDebut"] = $row["dateDebut"];
   $output["dateFin"] = $row["dateFin"];
 }
 echo json_encode($output);
}

if($_POST["action"] == "Update")
{
  $statement = $connection->prepare(
   "UPDATE sprint 
   SET numero = :numero, dateDebut = :dateDebut, dateFin = :dateFin 
   WHERE id = :id
   "
 );
  $result = $statement->execute(
   array(
    ':numero' => $_POST["numero"],
    ':dateDebut' => $_POST["dateDebut"],
    ':dateFin' => $_POST["dateFin"],
    ':id'   => $_POST["id"]
  )
 );
  if(!empty($result))
  {
   echo 'Sprint modifié ! 😮';
 }
}

if($_POST["action"] == "Delete")
{
  $statement = $connection->prepare(
   "DELETE FROM sprint WHERE id = :id"
 );
  $result = $statement->execute(
   array(
    ':id' => $_POST["id"]
  )
 );
  if(!empty($result))
  {
   echo 'Sprint supprimé ! 😢';
 }
}

}

?>
