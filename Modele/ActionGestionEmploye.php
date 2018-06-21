   <?php

   $username = 'root';
   $password = '';
   $connection = new PDO( 'mysql:host=localhost;dbname=scrum', $username, $password ); 

   if(isset($_POST["action"])) 
   {

     if($_POST["action"] == "Load") 
     {
      $statement = $connection->prepare("SELECT employe.id as id, employe.prenom as Prenom, employe.nom as Nom, employe.actif as Actif, employe.Couleur as Couleur FROM employe ORDER BY employe.actif desc, employe.prenom asc");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead>
      <tr>
      <th width="35%">Prénom</th>
      <th width="35%">Nom</th>
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
        <td style="background-color:'.$row["Couleur"].'"></td>
        <td>'.$row["Actif"].'</td>
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
     </tr>
     ';
   }
   $output .= '</tbody></table>';
   echo $output;
 }

 if($_POST["action"] == "Ajouter")
 {
  $statement = $connection->prepare("
   INSERT INTO employe (prenom, nom, Couleur, actif, Initial) 
   VALUES (:prenom, :nom, :Couleur, :actif, :Initial)
   ");

     $result = $statement->execute(
   array(
    ':prenom' => $_POST["Prenom_Employe"],
    ':nom' => $_POST["Nom_Employe"],
    ':Couleur' => $_POST["Couleur"],
    ':actif' => $_POST["Actif"],
    ':Initial' => $_POST["Initial"]
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
   $output["Couleur"] = $row["Couleur"];
   $output["Actif"] = $row["actif"];
 }
 echo json_encode($output);
}

if($_POST["action"] == "Update")
{
  $statement = $connection->prepare(
   "UPDATE employe 
   SET prenom = :prenom, nom = :nom, Couleur = :Couleur, Initial =:Initial, actif = :actif 
   WHERE id = :id
   "
 );
  $result = $statement->execute(
   array(
    ':prenom' => $_POST["Prenom_Employe"],
    ':nom' => $_POST["Nom_Employe"],
    ':Couleur' => $_POST["Couleur"],
    ':actif'   => $_POST["Actif"],
    ':Initial'   => $_POST["Initial"],
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
