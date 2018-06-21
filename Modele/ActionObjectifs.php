   <?php

   $username = 'root';
   $password = '';
   $connection = new PDO( 'mysql:host=localhost;dbname=scrum', $username, $password ); 

   if(isset($_POST["action"])) 
   {

     if($_POST["action"] == "Load") 
     {
      $numero = $_POST["idAffiche"];
      $statement = $connection->prepare("SELECT id as id, objectif as objectif, (SELECT couleur from statutobjectif where statutobjectif.id = objectif.id_StatutObjectif) as couleur, (Select nom from projet where projet.id = objectif.id_Projet) as projet, (SELECT nom from statutobjectif where statutobjectif.id = objectif.id_StatutObjectif) as etat FROM objectif Where id_Sprint = $numero ORDER BY (Select nom from projet where projet.id = objectif.id_Projet)");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead>
      <tr>
      <th width="10%">Etat</th>
      <th width="10%">Projet</th>
      <th width="70%">Objectif</th>
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
        <tr >
        <td style="background-color: '.$row["couleur"].'; color: white; font-weight: bold;">'.$row["etat"].'</td>
        <td>'.$row["projet"].'</td>
        <td>'.$row["objectif"].'</td>
        <td><center><div class="btn-group" role="group" aria-label="Basic example"><button type="button" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Changer</button><button type="button" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Supprimer</button></div></center></td>
        </tr>
        ';
      }
    }
    else
    {
     $output .= '
     <tr>
     <td align="center">💩</td>
     <td align="center">💩</td>
     <td align="center">💩</td>
     <td align="center">💩</td>
     </tr>
     ';
   }
   $output .= '</tbody></table>';
   echo $output;
 }


 if($_POST["action"] == "retrospective") 
     {
      $statement = $connection->prepare("SELECT id as id, DateCreation as DateCreation, Label as Label
        FROM retrospective
        WHERE Etat = 0
        ORDER BY DateCreation desc
        ");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead>
      <tr>
      <th width="10%">Date</th>
      <th width="85%">Remarque</th>
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
        <tr >
        <td>'.$row["DateCreation"].'</td>
        <td>'.$row["Label"].'</td>
        <td><center><div class="btn-group" role="group" aria-label="Basic example"><button type="button" id="'.$row["id"].'" class="btn btn-success btn-xs success">Fini</button></center></td>
        </tr>
        ';
      }
    }
    else
    {
     $output .= '
     <tr>
     <td align="center">💩</td>
     <td align="center">💩</td>
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
   INSERT INTO objectif (id_Sprint, id_Projet, objectif, id_StatutObjectif) 
   VALUES (:id_Sprint, :id_Projet, :objectif, :id_StatutObjectif)
   ");
  $result = $statement->execute(
   array(
    ':id_Sprint' => $_POST["idSprint"],
    ':id_Projet' => $_POST["idProjet"],
    ':objectif' => $_POST["LabelObjectif"],
    ':id_StatutObjectif' => $_POST["EtatObjectif"]
  )
 );
  if(!empty($result))
  {
   echo 'Objectif créé! ! 😄';
 }
}

 if($_POST["action"] == "CréerRetrospective")
 {
  $statement = $connection->prepare("
   INSERT INTO retrospective (Label, Etat, DateCreation) 
   VALUES (:Label, 0, NOW())
   ");
  $result = $statement->execute(
   array(
    ':Label' => $_POST["Labelretrospective"]
  )
 );
  if(!empty($result))
  {
   echo 'Retrospective créée! ! 😄';
 }
}

if($_POST["action"] == "Select")
{
  $output = array();
  $statement = $connection->prepare(
   "SELECT * FROM objectif 
   WHERE id = '".$_POST["id"]."' 
   LIMIT 1"
 );
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
   $output["id_Projet"] = $row["id_Projet"];
   $output["objectif"] = $row["objectif"];
   $output["id_StatutObjectif"] = $row["id_StatutObjectif"];
 }
 echo json_encode($output);
}

if($_POST["action"] == "Changer")
{
  $statement = $connection->prepare(
   "UPDATE objectif 
   SET objectif = :LabelObjectif, id_Sprint = :id_Sprint, id_Projet = :id_Projet, id_StatutObjectif = :EtatObjectif 
   WHERE id = :id
   "
 );
  $result = $statement->execute(
   array(
    ':LabelObjectif' => $_POST["LabelObjectif"],
    ':id_Sprint' => $_POST["idSprint"],
    ':id_Projet' => $_POST["idProjet"],
    ':EtatObjectif'   => $_POST["EtatObjectif"],
    ':id'   => $_POST["id"]
  )
 );
  if(!empty($result))
  {
   echo 'Objectif modifié ! 😮';
 }
}

if($_POST["action"] == "retrospectiveFini")
{
  $statement = $connection->prepare(
   "UPDATE retrospective 
   SET Etat = 1
   WHERE id = :id
   ");
  $result = $statement->execute(
   array(
    ':id'   => $_POST["id"]
  )
 );
    if(!empty($result))
  {
   echo 'Remarque validé! ! 😮';
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
