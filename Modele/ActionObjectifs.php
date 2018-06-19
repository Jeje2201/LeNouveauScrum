   <?php

   $username = 'root';
   $password = '';
   $connection = new PDO( 'mysql:host=localhost;dbname=scrum', $username, $password ); 

   if(isset($_POST["action"])) 
   {

     if($_POST["action"] == "Load") 
     {
      $numero = $_POST["idAffiche"];
      $statement = $connection->prepare("SELECT id as id, objectif as objectif, (Select nom from projet where projet.id = objectif.id_Projet) as projet, (SELECT nom from statutobjectif where statutobjectif.id = objectif.id_StatutObjectif) as etat FROM objectif Where id_Sprint = $numero");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead>
      <tr>
      <th width="10%">Projet</th>
      <th width="70%">Objectif</th>
      <th width="10%">Etat</th>
      <th width="5%%"><center>Editer</center></th>
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
        <td>'.$row["projet"].'</td>
        <td>'.$row["objectif"].'</td>
        <td>'.$row["etat"].'</td>
        <td><center><div class="btn-group" role="group" aria-label="Basic example"><button type="button" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Changer</button><button type="button" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Supprimer</button></div></center></td>
        </tr>
        ';
      }
    }
    else
    {
     $output .= '
     <tr>
     <td align="center">Aucune donnée à afficher 💩</td>
     </tr>
     ';
   }
   $output .= '</tbody></table>';
   echo $output;
 }

 if($_POST["action"] == "Attribuer")
 {
  $statement = $connection->prepare("
   INSERT INTO attribution (heure, id_Sprint, id_Employe, id_Projet) 
   VALUES (:NombreHeure, :idSprint, :idEmploye, :idProjet)
   ");
  $result = $statement->execute(
   array(
    ':NombreHeure' => $_POST["NombreHeure"],
    ':idSprint' => $_POST["idSprint"],
    ':idEmploye' => $_POST["idEmploye"],
    ':idProjet' => $_POST["idProjet"]
  )
 );
  if(!empty($result))
  {
   echo 'Heure(s) Attribuée(s) ! 😄';
 }
}

if($_POST["action"] == "Select")
{
  $output = array();
  $statement = $connection->prepare(
   "SELECT * FROM attribution 
   WHERE id = '".$_POST["id"]."' 
   LIMIT 1"
 );
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
   $output["heure"] = $row["heure"];
   $output["id_Employe"] = $row["id_Employe"];
   $output["id_Projet"] = $row["id_Projet"];
 }
 echo json_encode($output);
}

if($_POST["action"] == "Update")
{
  $statement = $connection->prepare(
   "UPDATE attribution 
   SET heure = :heure, id_Sprint = :id_Sprint, id_Projet = :id_Projet, id_Employe = :id_Employe 
   WHERE id = :id
   "
 );
  $result = $statement->execute(
   array(
    ':heure' => $_POST["NombreHeure"],
    ':id_Sprint' => $_POST["idSprint"],
    ':id_Projet' => $_POST["idProjet"],
    ':id_Employe'   => $_POST["idEmploye"],
    ':id'   => $_POST["id"]
  )
 );
  if(!empty($result))
  {
   echo 'Heure(s) attribuée(s) modifiée(s) ! 😮';
 }
}

if($_POST["action"] == "Delete")
{
  $statement = $connection->prepare(
   "DELETE FROM objectif WHERE id = :id"
 );
  $result = $statement->execute(
   array(
    ':id' => $_POST["id"]
  )
 );
  if(!empty($result))
  {
   echo 'Objectif supprimé ! 😢';
 }
}

}

?>
