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

        $statement = $connection->prepare("SELECT id as id, nom as nom from typeinterference order by id asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<select class="form-control"  id="typeinterference" name="typeinterference">';

        if($statement->rowCount() > 0)
        {
          foreach($result as $row)
            {

              $output2.='<option value="'.$row["id"].'">'.$row["nom"].'</option>';

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

        case 'ListEmployeCheckBox':

        $statement = $connection->prepare("SELECT id, prenom, nom from employe where employe.actif = 1 order by prenom asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '';
        $output2.='<input type="checkbox" style="margin-left: 9px;" name="ListEmployeCheckBox1" id="TOUTLEMONDE" value="TOUTLEMONDE"> Tout le monde<hr>';
        if($statement->rowCount() > 0)
        {
          foreach($result as $row)
            {

              $output2.='<input type="checkbox" class="checkbox" style="margin-left: 9px;" name="ListEmployeCheckBox1" id="ListEmployeCheckBox1" value="'.$row["id"].'">  '.$row["prenom"].' '.$row["nom"].'</br>';

            }

        }

        echo $output2;
            
        break; 

        case 'RemplirTypeTache':

        $statement = $connection->prepare("SELECT id, nom, couleur from typetache order by nom asc");

        $statement->execute();
        $result = $statement->fetchAll();
        $output2 = '<select class="form-control"  id="RemplirTypeTache1" name="RemplirTypeTache1">';

        if($statement->rowCount() > 0)
        {
          foreach($result as $row)
            {

             $output2.='<option style="background-color:'.$row["couleur"].'; color:black" value="'.$row["id"].'"> '.$row["nom"].' </option></br>';

            }

          $output2 .= '</select>';
        }

        echo $output2;
            
        break; 

      }
}
?>
