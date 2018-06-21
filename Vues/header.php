<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Jeremy">
	<link rel="icon" href="Assets/Icone.ico" />
	<title>ScrumJeremy</title>
	<!-- Bootstrap core CSS-->
	<link href="Assets/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom fonts for this template-->
	<link href="Assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- Custom styles for this template-->
	<link href="Assets/css/bootstrap-datetimepicker.css" rel="stylesheet">
	<link href="Assets/css/sb-admin.css" rel="stylesheet">
	<!-- Classe pour le Hightsharr-->
	
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
					<a class="nav-link" href="index.php?vue=Acceuil">
						<i class="fa fa-fw fa-home" aria-hidden="true"></i>
						<span class="nav-link-text">Accueil</span>
					</a>
				</li>
				<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
					<a class="nav-link" href="index.php?vue=Sprint">
						<i class="fa fa-fw fa-rocket"></i>
						<span class="nav-link-text">Sprints</span>
					</a>
				</li>
				<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Heures Attribuées">
					<a class="nav-link" href="index.php?vue=Attribution">
						<i class="fa fa-fw fa-arrow-down"></i>
						<span class="nav-link-text">Heures Attribuées</span>
					</a>
				</li>
				<li class="nav-item" data-toggle="tooltip" data-placement="right" title="HeuresDescendues">
					<a class="nav-link" href="index.php?vue=Descendation">
						<i class="fa fa-fw fa-arrow-up"></i>
						<span class="nav-link-text">Heures Descendues</span>
					</a>
				</li>
			</li>
			<li class="nav-item" data-toggle="tooltip" data-placement="right" title="BurnDownChart">
				<a class="nav-link" href="index.php?vue=Burndownchart">
					<i class="fa fa-fw fa-area-chart"></i>
					<span class="nav-link-text">BurnDownChart</span>
				</a>
			</li>
			<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Objectifs">
				<a class="nav-link" href="index.php?vue=Objectifs">
					<i class="fa fa-fw fa-sticky-note-o"></i>
					<span class="nav-link-text">Objectifs</span>
				</a>
			</li>
			<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Retrospective">
				<a class="nav-link" href="index.php?vue=Retrospective">
					<i class="fa fa-fw fa-bullseye"></i>
					<span class="nav-link-text">Retrospective</span>
				</a>
			</li>
			<li class="nav-item" data-toggle="tooltip" data-placement="right" title="" data-original-title="Menu Levels">
				<a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti" data-parent="#exampleAccordion" aria-expanded="false">
					<i class="fa fa-fw fa-wrench" aria-hidden="true"></i>
					<span class="nav-link-text">Gestions</span>
				</a>
				<ul class="sidenav-second-level collapse" id="collapseMulti">
					<li>
						<a href="index.php?vue=Parametres"><i class="fa fa-fw fa-cogs" aria-hidden="true"></i> Paramètres</a>
					</li>
					<li>
						<a href="index.php?vue=GestionSprint"><i class="fa fa-fw fa-rocket" aria-hidden="true"></i></i> Sprints</a>
					</li>
					<li>
						<a href="index.php?vue=GestionEmploye"><i class="fa fa-fw fa-users" aria-hidden="true"></i> Employés</a>
					</li>
					<li>
						<a href="#"><i class="fa fa-fw fa-gamepad" aria-hidden="true"></i> Projets</a>
					</li>
					<li>
						<a href="#"><i class="fa fa-fw fa-arrow-down" aria-hidden="true"></i> Heures Attribuées</a>
					</li>
					<li>
						<a href="index.php?vue=GestionDescendation"><i class="fa fa-fw fa-arrow-up" aria-hidden="true"></i> Heures Descendues</a>
					</li>
				</ul>
			</li>
		</ul>
		<ul class="navbar-nav sidenav-toggler">
			<li class="nav-item" id="SlideNav">
				<a class="nav-link text-center" id="sidenavToggler">
					<i class="fa fa-fw fa-angle-left"></i>
				</a>
			</li>
		</ul>
	</div>
</nav>
</body>
<script src="Controleur/jquery.min.js"></script>
<script src="Controleur/highcharts.js"></script>
<script src="Controleur/popper.min.js"></script>
<script src="Controleur/bootstrap.min.js"></script>
<script src="Controleur/getdataformulNEW.js"></script>
<script src="Controleur/AlertBootStrap.js"></script>
<script src="Controleur/ChoixDate.js"></script>
<script src="Controleur/ClassActive.js"></script>
<script src="Controleur/bootstrap-datetimepicker.js"></script>
<script src="Controleur/ReductionNav.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>