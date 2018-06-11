   <?php
//Database connection by using PHP PDO
$username = 'root';
$password = '';
$connection = new PDO( 'mysql:host=localhost;dbname=scrum', $username, $password ); // Create Object of PDO class by connecting to Mysql database

if(isset($_POST["action"])) //Check value of $_POST["action"] variable value is set to not
{
 //For Load All Data
 if($_POST["action"] == "Load") 
 {
  $numero = $_POST["idAffiche"];
  $statement = $connection->prepare("SELECT attribution.id, attribution.heure as NbHeure, projet.nom as projet, employe.prenom as employe FROM attribution inner JOIN employe ON employe.id = attribution.id_Employe INNER JOIN projet ON projet.id = attribution.id_Projet INNER JOIN sprint ON sprint.id = attribution.id_Sprint where attribution.id_Sprint = $numero ORDER BY attribution.id DESC");
  $statement->execute();
  $result = $statement->fetchAll();
  $output = '';
  $output .= '
   <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
    <thead>
    <tr>
     <th width="30%">Employé(e)</th>
     <th width="30%">Projet</th>
     <th width="30%">Heure(s)</th>
     <th width="5%"><center>Editer</center></th>
     <th width="5%"><center>Supprimer</center></center></th>
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
     <td>'.$row["employe"].'</td>
     <td>'.$row["projet"].'</td>
     <td>'.$row["NbHeure"].'</td>
     <td><center><button type="button" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Editer</button></center></td>
     <td><center><button type="button" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Supprimer</button></center></td>
    </tr>
    ';
   }
  }
  else
  {
   $output .= '
    <tr>
     <td align="center">Aucune donnée à afficher 😰</td>
    </tr>
   ';
  }
  $output .= '</tbody></table>';
  echo $output;
 }

 //This code for Create new Records
 if($_POST["action"] == "Create")
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

 //This Code is for fetch single customer data for display on Modal
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
   "DELETE FROM attribution WHERE id = :id"
  );
  $result = $statement->execute(
   array(
    ':id' => $_POST["id"]
   )
  );
  if(!empty($result))
  {
   echo 'Heure attribuée supprimée ! 😢';
  }
 }

}

?>
 