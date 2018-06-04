    <html>

        <meta charset="utf-8" />
        <link rel="stylesheet" href="css\dataTables.bootstrap.min.css"/>
        <link rel="stylesheet" href="css\style.css" />
        <link rel="stylesheet" href="css\bootstrap.css" />

        <script src="js\jquery-3.1.1.min.js"></script>
        <script src="js\bootstrap.min.js"></script>
        <script src="js\bootstrap-datetimepicker.js"></script>
        <script src="js\jquery.dataTables.min.js"></script>
        <script src="js\dataTables.bootstrap.min.js"></script>
        <script src="js\highcharts.js"></script>
        <script src="js\exporting.js"></script>

        <title>Sprint</title>

        <ul class="nav nav-tabs nav-justified">
            <li class="active"><a href="index">Créer Sprint</a></li>
            <li><a href="page2">Attribution Heures</a></li>
            <li><a href="page3">Heures Descendues</a></li>
            <li><a href="page4">Burndownchart</a></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Editer <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Sprint</a></li>
                    <li><a href="#">Heures Attribuées</a></li>
                    <li><a href="#">Heures Descendues</a></li>
                </ul>
            </li>
        </ul>

        <!-- Variables Globals / Configs -->
        <?php
        $conn = new mysqli('localhost', 'root', '', 'scrum') 
        or die ('Cannot connect to db');

        $host = "localhost";
        ?>

        <script>
        //Set the active class for tab with page name
            $(document).ready(function(){
                var url = window.location.href;
                var array = url.split('/');
                var lastsegment = array[array.length-1];
                $('li.active').removeClass('active');
                $('a[href='+lastsegment+']').parent().addClass('active');
            });
            
        </script>

    </html>