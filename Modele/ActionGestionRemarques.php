   <?php

require_once ('../Modele/Configs.php');

   if(isset($_POST["action"])) 
   {

     if($_POST["action"] == "Load") 
     {
      $statement = $connection->prepare("SELECT * from retrospective order by DateCreation desc ");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead class="thead-light">
      <tr>
      <th width="">Début</th>
      <th width="">Fin</th>
      <th width="">Label</th>
      <th width=""><center>Éditer</center></th>
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
        <td>'.date("d-m-Y", strtotime($row["DateCreation"])).'</td>';
        if($row["DateFini"] == null)
        $output .= '<td></td>';
        else
        $output .= '<td>'.date("d-m-Y", strtotime($row["DateFini"])).'</td>';
        $output .= '
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

if($_POST["action"] == "Select")
{
  $output = array();
  $statement = $connection->prepare(
   "SELECT * FROM retrospective 
   WHERE id = '".$_POST["id"]."' 
   LIMIT 1"
 );
  $statement->execute();
  $result = $statement->fetch();

   $output["Debut"] = date("d-m-Y", strtotime($result["DateCreation"]));
   if($result["DateFini"] == null)
   $output["Fin"] = "";
   else
   $output["Fin"] = date("d-m-Y", strtotime($result["DateFini"]));
   $output["Label"] = $result["Label"];

 echo json_encode($output);
}

if($_POST["action"] == "UpdateAvecDateFin")
{
  $statement = $connection->prepare(
   "UPDATE retrospective
   SET Label = :Label, DateCreation = :DateDebut, DateFini = :DateFin 
   WHERE id = :id
   "
 );
  $result = $statement->execute(
   array(
     
    ':DateDebut' => $_POST["DateDebut"], 
    ':Label' => $_POST["Label"],
    ':DateFin'   => $_POST["DateFin"],
    ':id'   => $_POST["id"]
  )
 );
  if(!empty($result))
   echo '✓';
   else{
   print_r($statement->errorInfo());
  }
}

if($_POST["action"] == "UpdateSansDateFin")
{
  $statement = $connection->prepare(
   "UPDATE retrospective
   SET Label = :Label, DateCreation = :DateDebut 
   WHERE id = :id
   "
 );
  $result = $statement->execute(
   array(
     
    ':DateDebut' => $_POST["DateDebut"], 
    ':Label' => $_POST["Label"],
    ':id'   => $_POST["id"]
  )
 );
  if(!empty($result))
   echo '✓';
   else{
   print_r($statement->errorInfo());
  }
}

if($_POST["action"] == "Delete")
{
  $statement = $connection->prepare(
   "DELETE FROM rettrospective WHERE id = :id"
 );
  $result = $statement->execute(
   array(
    ':id' => $_POST["id"]
  )
 );
  if(!empty($result))
   echo '✓';
   else
   print_r($statement->errorInfo());
}

}

?>
