   <?php
   $username = 'root';
   $password = '';
   $connection = new PDO( 'mysql:host=localhost;dbname=scrum', $username, $password ); 
   if(isset($_POST["action"]))   {

    $action = $_POST["action"];

    switch($action)
    {
      case 'TableauDeSprint':
      $statement = $connection->prepare("SELECT * FROM sprint ORDER BY numero desc");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead>
      <tr>
      <th width="30%">Numero</th>
      <th width="30%">Date Debut</th>
      <th width="30%">Date Fin</th>
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
         <td>'.$row["numero"].'</td>
         <td>'.$row["dateDebut"].'</td>
         <td>'.$row["dateFin"].'</td>
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
     break;

}
}
?>
