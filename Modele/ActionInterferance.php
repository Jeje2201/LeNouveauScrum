   <?php

require_once ('../Modele/Configs.php');

   if(isset($_POST["action"])) 
   {

     if($_POST["action"] == "Load") 
     {
      $numero = $_POST["idAffiche"];
      $statement = $connection->prepare("SELECT interference.id as id, interference.heure as Heure,interference.label as Label, (select Prenom from employe where employe.id = interference.id_Employe) as Employe, (select nom from projet where projet.id = interference.id_Projet) as Projet, (select nom from typeinterference where typeinterference.id = interference.id_TypeInterference) as Type FROM interference Where id_Sprint = $numero ORDER BY interference.id_Projet asc");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-sm table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead>
      <tr>
      <th width="5%">Heures</th>
      <th width="15%">Ressource</th>
      <th width="20%">Projet</th>
      <th width="20%">Type</th>
      <th width="20%">Label</th>
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
        <td>'.$row["Heure"].'</td>
        <td>'.$row["Employe"].'</td>
        <td>'.$row["Projet"].'</td>
        <td>'.$row["Type"].'</td>
        <td>'.$row["Label"].'</td>
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

 if($_POST["action"] == "Ajouter")
 {
  $statement = $connection->prepare("
   INSERT INTO interference (heure, id_TypeInterference, id_Sprint, id_Projet, id_Employe, label) 
   VALUES (:heure, :typeinterference, :sprint, :projet, :employe, :label)
   ");

     $result = $statement->execute(
   array(
    ':heure' => $_POST["NbHeure"],
    ':typeinterference' => $_POST["TypeInterferance"],
    ':sprint' => $_POST["idAffichee"],
    ':projet' => $_POST["Projet"],
    ':label' => $_POST["labelinterference"],
    ':employe' => $_POST["Employe"]
  )
 );
  if(!empty($result))
   echo '✓';
   else
   echo 'X';
}

if($_POST["action"] == "Select")
{
  $output = array();
  $statement = $connection->prepare(
   "SELECT * FROM interference 
   WHERE id = '".$_POST["id"]."' 
   LIMIT 1"
 );
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
   $output["Heure"] = $row["heure"];
   $output["TypeInterferance"] = $row["id_TypeInterference"];
   $output["Sprint"] = $row["id_Sprint"];
   $output["Projet"] = $row["id_Projet"];
   $output["Employe"] = $row["id_Employe"];
   $output["labelinterference"] = $row["label"];
 }
 echo json_encode($output);
}

if($_POST["action"] == "Update")
{
  $statement = $connection->prepare(
   "UPDATE interference 
   SET heure = :heure, id_TypeInterference = :typeinterference, id_Sprint =:sprint, id_Projet = :projet, id_Employe = :employe, label = :label
   WHERE id = :id
   "
 );
  $result = $statement->execute(
   array(
    ':heure' => $_POST["NbHeure"],
    ':typeinterference' => $_POST["TypeInterferance"],
    ':sprint' => $_POST["idAffichee"],
    ':projet' => $_POST["Projet"],
    ':employe' => $_POST["Employe"],
    ':label' => $_POST["labelinterference"],
    ':id'   => $_POST["id"]
  )
 );
  if(!empty($result))
   echo '✓';
   else
   echo 'X';
}

if($_POST["action"] == "Delete")
{
  $statement = $connection->prepare(
   "DELETE FROM interference WHERE id = :id"
 );
  $result = $statement->execute(
   array(
    ':id' => $_POST["id"]
  )
 );
  if(!empty($result))
   echo '✓';
   else
   echo 'X';
}

}

?>
