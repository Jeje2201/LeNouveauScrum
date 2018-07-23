   <?php

   require_once ('../Modele/Configs.php');

   if(isset($_POST["action"]))   {

    $action = $_POST["action"];
   

    switch($action)
    {

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

      case 'ListeDeroulanteProjet':

        $statement = $connection->prepare("SELECT id as id, nom as Nom from projet order by nom asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<select class="form-control"  id="projetId" name="projetId">';

        if($statement->rowCount() > 0)
        {
          foreach($result as $row)
            {

              $output2.='<option value="'.$row["id"].'"> '.$row["Nom"].' </option>';

            }

          $output2 .= '</select>';
        }

        echo $output2;
          
      break;

      case 'ListeDeroulanteEmploye':

        $statement = $connection->prepare("SELECT id as id, prenom as Prenom, nom as Nom from employe order by prenom asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<select class="form-control"  id="employeId" name="employeId">';

        if($statement->rowCount() > 0)
        {
          foreach($result as $row)
            {

              $output2.='<option value="'.$row["id"].'"> '.$row["Prenom"].' '.$row["Nom"].' </option>';

            }

          $output2 .= '</select>';
        }

        echo $output2;
            
        break;

              case 'ListEmployeActifPlanification':

               $IdSprint = $_POST["IdSprint"];

        $statement = $connection->prepare("SELECT employe.id as id, prenom as Prenom, nom as Nom from employe where employe.actif = 1 UNION select employe.id as id, prenom as Prenom, nom as Nom from employe inner join attribution where employe.id = attribution.id_Employe and attribution.id_Sprint = $IdSprint ORDER BY `Prenom` ASC");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<select class="form-control"  id="employeId" name="employeId">';

        if($statement->rowCount() > 0)
        {
          foreach($result as $row)
            {

              $output2.='<option value="'.$row["id"].'"> '.$row["Prenom"].' '.$row["Nom"].' </option>';

            }

          $output2 .= '</select>';
        }

        echo $output2;
            
        break;

      case 'ListeDeroulanteEmployeActif':

        $statement = $connection->prepare("SELECT id as id, prenom as Prenom, nom as Nom from employe where employe.actif = 1 order by prenom asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<select class="form-control"  id="employeId" name="employeId">';

        if($statement->rowCount() > 0)
        {
          foreach($result as $row)
            {

              $output2.='<option value="'.$row["id"].'"> '.$row["Prenom"].' '.$row["Nom"].' </option>';

            }

          $output2 .= '</select>';
        }

        echo $output2;
            
        break;

        case 'ListeDeroulanteEmployeActifTrieParType':

        $statement = $connection->prepare("SELECT prenom, nom, id from employe where employe.actif = 1 order by prenom asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<select class="form-control"  id="TypeEmployeOk" name="TypeEmployeOk">';

        if($statement->rowCount() > 0)
        {
          foreach($result as $row)
            {

              $output2.='<option value="'.$row["id"].'"> '.$row["prenom"].' '.$row["nom"].' </option>';

            }

          $output2 .= '</select>';
        }

        echo $output2;
            
        break;

      case 'ListeDeroulanteTypeInterferance':

        $statement = $connection->prepare("SELECT id as id, nom as nom from typeinterference order by nom asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<select class="form-control"  id="typeinterference" name="typeinterference">';

        if($statement->rowCount() > 0)
        {
          foreach($result as $row)
            {

              $output2.='<option value="'.$row["id"].'"> '.$row["nom"].' </option>';

            }

          $output2 .= '</select>';
        }

        echo $output2;
            
        break;        

      case 'ListeDeroulanteTypeEmploye':

        $statement = $connection->prepare("SELECT id as id, nom as nom from typeemploye order by nom asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<select class="form-control"  id="TypeEmploye" name="TypeEmploye">';

        if($statement->rowCount() > 0)
        {
          foreach($result as $row)
            {

              if($row["nom"] == "Developpeur")
              $output2.='<option value="'.$row["id"].'" selected> '.$row["nom"].' </option>';
            else
              $output2.='<option value="'.$row["id"].'"> '.$row["nom"].' </option>';
            }

          $output2 .= '</select>';
        }

        echo $output2;
            
        break;

      case 'ListeDeroulanteTypeProjet':

        $statement = $connection->prepare("SELECT id as id, nom as nom from typeprojet order by nom asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<select class="form-control"  id="TypeProjet" name="TypeProjet">';

        if($statement->rowCount() > 0)
        {
          foreach($result as $row)
            {

              $output2.='<option value="'.$row["id"].'"> '.$row["nom"].' </option>';

            }

          $output2 .= '</select>';
        }

        echo $output2;
            
        break;

        case 'ListeDeroulanteEtatObjectif':

        $statement = $connection->prepare("SELECT id as id, nom as nom from statutobjectif order by nom asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<form class="form-control" name="EtatObjectif" id="EtatObjectif">';

        if($statement->rowCount() > 0)
        {
          foreach($result as $row)
            {

              $output2.='<label><input type="radio" name="Etat" id="EtatNum'.$row["id"].'" value="'.$row["id"].'">  '.$row["nom"].'</label><br>';

            }

          $output2 .= '</form>';
        }

        echo $output2;
            
        break; 

      }
}
?>
