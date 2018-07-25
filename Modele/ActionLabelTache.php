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
      <table class="table table-sm table-bordered" id="datatable" >
      <thead>
      <tr>
      <th width="5%">Heure</th>
      <th width="15%">Projet</th>
      <th width="75%">Label</th>
      <th width="5%" colspan="2"><center>Editer</center></th>
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
        <td><input class="form-control" name="LabelObjectif" id="LabelObjectif" type="text" value="'.$row["Label"].'"></td>

        <td><center><button type="button" id="'.$row["id"].'" class="btn btn-success update"><i class="fa fa-check" aria-hidden="true"></i></button></center></td>
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
  $statement = $connection->prepare(
   "UPDATE attribution 
   SET Label = :Label 
   WHERE id = :id
   "
 );
  $result = $statement->execute(
   array(
    ':Label'   => $_POST["label"],
    ':id'   => $_POST["id"]
  )
 );
  if(!empty($result))
  {
   echo 'Label de tâche modifié ! 😮';
 }
}

}

?>
