	<?php
    $HostName = "localhost";
    $HostUsername = "root";
    $HostPassword = "";
    $BddTableName = "scrum";
    $ProjectFolderName = "ScrumManager";

    //Etablir la connexion a la bdd en mysqli
    $conn = new mysqli($HostName, $HostUsername, $HostPassword, $BddTableName) 
    or die ('Cannot connect to db');

    //Etablir la connexion pour les requetes ajax
    $connection = new PDO( 'mysql:host='.$HostName.';dbname='.$BddTableName.'', $HostUsername, $HostPassword ); 


    ?>