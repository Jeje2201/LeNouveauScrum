   <?php

require_once ('../Modele/Configs.php');

   if(isset($_POST["action"])) 
   {

     if($_POST["action"] == "Load") 
     {
      $statement = $connection->prepare("SELECT projet.id as id, projet.nom as Nom, projet.cheminIcone as Icone, (select nom from typeprojet where typeprojet.id = projet.id_TypeProjet ) as TypeProjet FROM projet ORDER BY projet.nom desc");
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
        <td>'.$row["Icone"].'</td>
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
   INSERT INTO employe (prenom, nom, Couleur, actif, Initial, id_TypeEmploye) 
   VALUES (:prenom, :nom, :Couleur, :actif, :Initial, :Type_Employe)
   ");

     $result = $statement->execute(
   array(
    ':prenom' => $_POST["Prenom_Employe"],
    ':nom' => $_POST["Nom_Employe"],
    ':Couleur' => '#'.random_color(),
    ':actif' => $_POST["Actif"],
    ':Initial' => $_POST["Initial"],
    ':Type_Employe' => $_POST["Type_Employe"]
  )
 );
  if(!empty($result))
  {
   echo 'Nouvel(le) employé(e) / Stagiaire ! 😄';
 }
}

if($_POST["action"] == "Select")
{
  $output = array();
  $statement = $connection->prepare(
   "SELECT * FROM employe 
   WHERE id = '".$_POST["id"]."' 
   LIMIT 1"
 );
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
   $output["Prenom"] = $row["prenom"];
   $output["Nom"] = $row["nom"];
   $output["Actif"] = $row["actif"];
   $output["TypeEmploye"] = $row["id_TypeEmploye"];
 }
 echo json_encode($output);
}

if($_POST["action"] == "Update")
{
  $statement = $connection->prepare(
   "UPDATE employe 
   SET prenom = :prenom, nom = :nom, Initial =:Initial, actif = :actif, id_TypeEmploye = :Type_Employe
   WHERE id = :id
   "
 );
  $result = $statement->execute(
   array(
    ':prenom' => $_POST["Prenom_Employe"],
    ':nom' => $_POST["Nom_Employe"],
    ':actif'   => $_POST["Actif"],
    ':Initial'   => $_POST["Initial"],
    ':Type_Employe' => $_POST["Type_Employe"],
    ':id'   => $_POST["id"]
  )
 );
  if(!empty($result))
  {
   echo 'Employé(e) Modifi(e) ! 😮';
 }
}

if($_POST["action"] == "Delete")
{
  $statement = $connection->prepare(
   "DELETE FROM employe WHERE id = :id"
 );
  $result = $statement->execute(
   array(
    ':id' => $_POST["id"]
  )
 );
  if(!empty($result))
  {
   echo 'Employé(e) supprimé(e) ! 😢';
 }
}

}

?>
