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
	<link href="Assets/css/bootstrap.css" rel="stylesheet">
	<!-- Custom fonts for this template-->
	<link href="Assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- Custom styles for this template-->
	<link href="Assets/css/bootstrap-datetimepicker.css" rel="stylesheet">
	<link href="Assets/css/sb-admin.css" rel="stylesheet">
	<!-- Classe pour le Hightsharr-->

	<link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" rel="stylesheet">

	
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body" id="InterieurDeLalert">
			</div>
		</div>
	</div>
</div>
</body>

<script src="Assets/Js/jquery.min.js"></script>
<script src="Assets/Js/highcharts.js"></script>
<script src="Assets/Js/popper.min.js"></script>
<script src="Assets/Js/bootstrap.min.js"></script>
<script src="Assets/Js/AlertBootStrap.js"></script>
<script src="Assets/Js/ChoixDate.js"></script>
<script src="Assets/Js/ClassActive.js"></script>
<script src="Assets/Js/bootstrap-datetimepicker.js"></script>
<script src="Assets/Js/ReductionNav.js"></script>
<script src="Assets/Js/jsPDF.js"></script>
<script src="Assets/Js/exporting.js"></script>
<script src="Assets/Js/RemplirListSprint.js"></script>
<script src="Assets/Js/BarreDeRecherche.js"></script>


<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>