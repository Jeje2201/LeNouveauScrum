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

      }
}
?>
