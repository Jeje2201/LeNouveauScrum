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
  $statement = $connection->prepare("SELECT * FROM sprint ORDER BY id DESC");
  $statement->execute();
  $result = $statement->fetchAll();
  $output = '';
  $output .= '
   <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
    <tr>
     <th>Numero</th>
     <th>Date Debut</th>
     <th>Date Fin</th>
     <th>Update</th>
     <th>Delete</th>
    </tr>
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
     <td><button type="button" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Update</button></td>
     <td><button type="button" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Delete</button></td>
    </tr>
    ';
   }
  }
  else
  {
   $output .= '
    <tr>
     <td align="center">Data not Found</td>
    </tr>
   ';
  }
  $output .= '</table>';
  echo $output;
 }

 //This code for Create new Records
 if($_POST["action"] == "Create")
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
   echo 'Sprint créé!';
  }
 }

 //This Code is for fetch single customer data for display on Modal
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
   echo 'Sprint modifié!';
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
   echo 'Data Deleted';
  }
 }

}

?>
 