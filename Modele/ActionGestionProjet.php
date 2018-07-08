   <?php

require_once ('../Modele/Configs.php');

   if(isset($_POST["action"])) 
   {

     if($_POST["action"] == "Load") 
     {
      $statement = $connection->prepare("SELECT projet.id as id, projet.nom as Nom, projet.cheminIcone as Icone, (select nom from typeprojet where typeprojet.id = projet.id_TypeProjet ) as TypeProjet FROM projet ORDER BY projet.nom asc");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead>
      <tr>
      <th width="40%">Nom</th>
      <th width="40%">Type</th>
      <th width="10%">Icone</th>
      <th width="10%"><center>Editer</center></th>
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
        <td>'.$row["Nom"].'</td>
        <td>'.$row["TypeProjet"].'</td>
        <td><img src=Assets/Image/Projets/'.$row["Icone"].' width="35" height="35"></td>
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
   INSERT INTO projet (nom, cheminIcone, id_TypeProjet) 
   VALUES (:Nom, :cheminIcone, :id_TypeProjet)
   ");

     $result = $statement->execute(
   array(
    ':Nom' => $_POST["Nom"],
    ':cheminIcone' => $_POST["fileName"],
    ':id_TypeProjet' => $_POST["TypeProjet"]
  )
 );
  if(!empty($result))
  {
   echo 'Nouveau projet ! 😄';
 }
 else{
  echo 'Erreur :c';
 }
}

if($_POST["action"] == "Select")
{
  $output = array();
  $statement = $connection->prepare(
   "SELECT * FROM projet 
   WHERE id = '".$_POST["id"]."' 
   LIMIT 1"
 );
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {




   $output["Nom"] = $row["nom"];
   $output["cheminIcone"] = $row["cheminIcone"];
   $output["TypeProjet"] = $row["id_TypeProjet"];
 }
 echo json_encode($output);
}

if($_POST["action"] == "Update")
{
  $statement = $connection->prepare(
   "UPDATE projet 
   SET nom = :nom, cheminIcone =:cheminIcone, id_TypeProjet = :id_TypeProjet
   WHERE id = :id
   "
 );
  $result = $statement->execute(
   array(
    ':nom' => $_POST["Nom"],
    ':cheminIcone'   => $_POST["fileName"],
    ':id_TypeProjet'   => $_POST["TypeProjet"],
    ':id'   => $_POST["id"]
  )
 );
  if(!empty($result))
  {
   echo 'Projet modifié ! 😮';
 }
}

if($_POST["action"] == "Delete")
{
  $statement = $connection->prepare(
   "DELETE FROM projet WHERE id = :id"
 );
  $result = $statement->execute(
   array(
    ':id' => $_POST["id"]
  )
 );
  if(!empty($result))
  {
   echo 'Projet supprimé ! 😢';
 }
}

}

?>
