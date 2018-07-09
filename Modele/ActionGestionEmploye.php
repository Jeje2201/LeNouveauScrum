   <?php

function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}

require_once ('../Modele/Configs.php');

   if(isset($_POST["action"])) 
   {

     if($_POST["action"] == "Load") 
     {
      $statement = $connection->prepare("SELECT employe.id as id, employe.prenom as Prenom, employe.nom as Nom, employe.actif as Actif, (select nom from typeemploye where typeemploye.id = employe.id_TypeEmploye ) as TypeJob, employe.Couleur as Couleur FROM employe ORDER BY employe.actif desc, employe.prenom asc");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead>
      <tr>
      <th width="25%">Prénom</th>
      <th width="25%">Nom</th>
      <th width="20%">Job</th>
      <th width="10%">Couleur</th>
      <th width="10%">Actif</th>
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
        <td>'.$row["Prenom"].'</td>
        <td>'.$row["Nom"].'</td>
        <td>'.$row["TypeJob"].'</td>
        <td style="background-color:'.$row["Couleur"].'"></td>
        <td>'.$row["Actif"].'</td>
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
   echo 'Bienvenue nouvelle ressource ! 😄';
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
   echo 'Ressource modifiée ! 😮';
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
   echo 'Ressource supprimée ! 😢';
 }
}

}

?>
