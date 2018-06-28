   <?php

   require_once ('../Modele/Configs.php');

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
         <td><center><div class="btn-group" role="group" aria-label="Basic example"><button type="button" id="'.$row["id"].'" class="btn btn-warning update"><i class="fa fa-pencil" aria-hidden="true"></i></button><button type="button" id="'.$row["id"].'" class="btn btn-danger  delete"><i class="fa fa-times" aria-hidden="true"></i></button></div></center></td>
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
     break;

     case 'TableauDeSprint2':
      $statement = $connection->prepare("SELECT * FROM sprint ORDER BY numero desc");
      $statement->execute();
      $result = $statement->fetchAll();
      if($statement->rowCount() > 0)
      {
       foreach($result as $row)
       {

         $test["numero"] = $row["numero"];
         $test["dateDebut"] = $row["dateDebut"];
         $test["dateFin"] = $row["dateFin"];
         $test["id"] = $row["id"];

          echo json_encode($test);

       }

     }
    
     break;

     case 'ListeDeroulanteSprint':

      $statement = $connection->prepare("SELECT id as id, numero as numero from sprint order by numero desc");

      $statement->execute();
      $result = $statement->fetchAll();
      $output2 = '<select class="form-control"  id="numeroSprint" name="numeroSprint">';

      if($statement->rowCount() > 0)
      {
        foreach($result as $row)
          {

            $output2.='<option value="'.$row["id"].'"> '.$row["numero"].' </option>';

          }

        $output2 .= '</select>';
      }

      echo $output2;
          
      break;

      }
}
?>
