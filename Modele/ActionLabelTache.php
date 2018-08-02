   <?php
   
require_once ('../Modele/Configs.php');

   if(isset($_POST["action"])) 
   {

     if($_POST["action"] == "Load") 
     {
      $idEmploye = $_POST["idEmploye"];
      $statement = $connection->prepare("
        SELECT  (select projet.nom from projet where projet.id = attribution.id_Projet) as projet ,attribution.id, attribution.heure, attribution.Label from attribution where id_Employe = $idEmploye and id_sprint = (select id from sprint ORDER BY id desc LIMIT 1)");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-sm table-striped table-bordered" id="datatable" >
      <thead class="thead-light">
      <tr>
      <th width="5%">H</th>
      <th width="15%">Projet</th>
      <th width="75%">Label</th>
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
        <td>'.$row["heure"].'</td>
        <td>'.$row["projet"].'</td>
        <td><input class="form-control" name="LabelObjectif" id="'.$row["id"].'" type="text" value="'.$row["Label"].'"></td>
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


 if($_POST["action"] == "Changer")
 {

  $TableauLabelObjectuf = $_POST["ToReturn"];

  $statement = $connection->prepare(
   "UPDATE attribution 
   SET Label = :Label 
   WHERE id = :id
   "
 );

  for($i=0; $i < count($TableauLabelObjectuf);$i++){

    $result = $statement->execute(
     array(
      ':id' => $TableauLabelObjectuf[$i][0],
     ':Label' => $TableauLabelObjectuf[$i][1]
   )
  );
 }
 echo '✓';
}

}

?>
