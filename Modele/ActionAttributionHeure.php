   <?php

require_once ('../Modele/Configs.php');

   if(isset($_POST["action"])) 
   {

     if($_POST["action"] == "RemplirTableau") 
     {
      $numero = $_POST["idAffiche"];
      $statement = $connection->prepare("SELECT attribution.id, attribution.Label as Label, attribution.heure as NbHeure, projet.nom as projet, employe.prenom as employeP, employe.nom as employeN FROM attribution inner JOIN employe ON employe.id = attribution.id_Employe INNER JOIN projet ON projet.id = attribution.id_Projet INNER JOIN sprint ON sprint.id = attribution.id_Sprint where attribution.id_Sprint = $numero ORDER BY attribution.id DESC");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead class="thead-light">
      <tr>
      <th width="20%">Ressource</th>
      <th width="25%">Projet</th>
      <th width="40%">Label</th>
      <th width="5%"><center>H</center></th>
      <th width="10%"><center>Éditer</center></th>
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
        <td>'.$row["employeP"].' '.$row["employeN"].'</td>
        <td>'.$row["projet"].'</td>
        <td>'.$row["Label"].'</td>
        <td><center>'.$row["NbHeure"].'</center></td>
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
     </tr>
     ';
   }
   $output .= '</tbody></table>';
   echo $output;
 }

      if($_POST["action"] == "RemplirTableauRessources") 
     {
      $numero = $_POST["idAffiche"];

      $statement = $connection->prepare("SELECT  sum(attribution.heure) as NbHeure, ((SELECT Attribuable from sprint where sprint.id = $numero)- sum(attribution.heure)) as Attribuable, employe.prenom as employeP, employe.nom as employeN FROM attribution inner JOIN employe ON employe.id = attribution.id_Employe INNER JOIN sprint ON sprint.id = attribution.id_Sprint where attribution.id_Sprint = $numero group by attribution.id_Employe ORDER BY employeP ASC");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-sm table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead class="thead-light">
      <tr>
      <th width="50%">Ressource</th>
      <th width="50%">Planifié (Disponible)</th>
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
        <td>'.$row["employeP"].' '.$row["employeN"].'</td>';
        if($row["Attribuable"] == 0){
        $output .= '<td style="background-color:#baffc9">'.$row["NbHeure"].' ('.$row["Attribuable"].')</td>';
        }
        if($row["Attribuable"] > 0){
        $output .= '<td>'.$row["NbHeure"].' ('.$row["Attribuable"].')</td>';
        }
        if($row["Attribuable"] < 0){
        $output .= '<td style="background-color:#ffb3ba">'.$row["NbHeure"].' ('.$row["Attribuable"].')</td>';
        }
        $output .= '</tr>';
        
      }
    }
   $output .= '</tbody></table>';
   echo $output;
 }

       if($_POST["action"] == "RemplirTableauProjets") 
     {
      $numero = $_POST["idAffiche"];
      $statement = $connection->prepare("SELECT  sum(attribution.heure) as NbHeure, projet.nom as ProjetN FROM attribution inner JOIN projet ON projet.id = attribution.id_Projet INNER JOIN sprint ON sprint.id = attribution.id_Sprint where attribution.id_Sprint = $numero group by attribution.id_Projet ORDER BY ProjetN ASC");
      $statement->execute();
      $result = $statement->fetchAll();
      $output = '';
      $output .= '
      <table class="table table-sm table-striped table-bordered" id="datatable" width="100%" cellspacing="0">
      <thead class="thead-light">
      <tr>
      <th width="90%">Projet</th>
      <th width="10%">H</th>
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
        <td>'.$row["ProjetN"].'</td>
        <td>'.$row["NbHeure"].'</td>
        </tr>
        ';
      }
    }
   $output .= '</tbody></table>';
   echo $output;
 }

 if($_POST["action"] == "Attribuer")
 {
  $TableauHeurePlanifie = $_POST["NombreHeure"];
  $statement = $connection->prepare("
   INSERT INTO attribution (heure, id_Sprint, id_Employe, id_Projet, Label) 
   VALUES (:NombreHeure, :idSprint, :idEmploye, :idProjet, :Label)
   ");
  for($i=0; $i < count($TableauHeurePlanifie);$i++){

$result = $statement->execute(
   array(
    ':NombreHeure' => intval($TableauHeurePlanifie[$i]),
    ':idSprint' => $_POST["idSprint"],
    ':Label' => "?",
    ':idEmploye' => $_POST["idEmploye"],
    ':idProjet' => $_POST["idProjet"]
  )
 );
  if(!empty($result))
   echo '✓';
   else
   echo 'X';
  }
}

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
   echo ' ✓ ';
   else
   echo 'X ';
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
   echo '✓';
   else
   echo 'X';
}

if($_POST["action"] == "AttributionScrumPlaning")
 {
  $TableauEmploye = $_POST["idEmploye"];
  $statement = $connection->prepare("
   INSERT INTO attribution (heure, id_Sprint, id_Employe, id_Projet, id_TypeTache, Label) 
   VALUES (:NombreHeure, :idSprint, :idEmploye, (select id from projet where projet.nom = 'ScrumPlaning'), :TypeTache, (select nom from typetache where typetache.id = :TypeTache))
   ");
  for($i=0; $i < count($TableauEmploye);$i++){

$result = $statement->execute(
   array(
    ':NombreHeure' => intval($_POST["NombreHeure"]),
    ':idSprint' => intval($_POST["idSprint"]),
    ':idEmploye' => intval($TableauEmploye[$i]),
    ':TypeTache' => intval($_POST["idTypeTache"])
  )
 );
  if(!empty($result))
   echo '✓';
   else
   echo 'X';
  }
}

}

?>
