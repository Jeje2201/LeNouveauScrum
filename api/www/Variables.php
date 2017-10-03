<?php
    $HostName = "localhost";
    $HostUsername = "root";
    $HostPassword = "";
    $BddTableName = "scrum";
    $ProjectFolderName = "LeNouveauScrum";
    
    $conn = new mysqli($HostName, $HostUsername, $HostPassword, $BddTableName) 
    or die ('Cannot connect to db');
    ?>