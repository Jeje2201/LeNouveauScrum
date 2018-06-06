<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Jeremy">
	<link rel="icon" href="Icone.ico" />
	<title>ScrumJeremy</title>
	<!-- Bootstrap core CSS-->
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom fonts for this template-->
	<link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- Custom styles for this template-->
	<link href="css/bootstrap-datetimepicker.css" rel="stylesheet">
	<link href="css/sb-admin.css" rel="stylesheet">
    <!-- Classe pour le Hightsharr-->
    <script src="js/highcharts.js"></script>
    
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
		<a class="navbar-brand" href="index.php">Ns Scrum</a>
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarResponsive">
			<ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
				<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Accueil">
					<a class="nav-link" href="Index.php">
					<i class="fa fa-fw fa-user"></i>
					<span class="nav-link-text">Accueil</span>
					</a>
				</li>
				<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
					<a class="nav-link" href="CreerSprint.php">
					<i class="fa fa-fw fa fa-plus"></i>
					<span class="nav-link-text">Sprints</span>
					</a>
				</li>
				<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Heures Attribuées">
					<a class="nav-link" href="AttributionHeures.php">
					<i class="fa fa-fw fa-table"></i>
					<span class="nav-link-text">Heures Attribuées</span>
					</a>
				</li>
				<li class="nav-item" data-toggle="tooltip" data-placement="right" title="HeiresDescendues">
					<a class="nav-link" href="HeuresDescendues.php">
					<i class="fa fa-fw fa-table"></i>
					<span class="nav-link-text">Heures Descendues</span>
					</a>
				</li>
				</li>
				<li class="nav-item" data-toggle="tooltip" data-placement="right" title="BurnDownChart">
					<a class="nav-link" href="BurnDownChart.php">
					<i class="fa fa-fw fa-area-chart"></i>
					<span class="nav-link-text">BurnDownChart</span>
					</a>
				</li>
			</ul>
			<ul class="navbar-nav ml-auto">
                <a class="nav-link mr-lg-2" id="toggleNavColor" href="#" data-toggle="" aria-haspopup="true" aria-expanded="false">
				<i class="fa fa-fw fa-lightbulb-o"></i>
				</a>
			</ul>
		</div>
	</nav>
    <?php require_once __Dir__ . '/api/www/Configs.php'; ?>
</body>