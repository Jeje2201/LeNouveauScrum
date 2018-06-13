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
					<i class="fa fa-fw fa fa fa-calendar"></i>
					<span class="nav-link-text">Heures Attribuées</span>
					</a>
				</li>
				<li class="nav-item" data-toggle="tooltip" data-placement="right" title="HeiresDescendues">
					<a class="nav-link" href="HeuresDescendues.php">
					<i class="fa fa-fw fa fa-thumbs-up"></i>
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
				<li class="nav-item" data-toggle="tooltip" data-placement="right" title="" data-original-title="Menu Levels">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti" data-parent="#exampleAccordion" aria-expanded="false">
            <i class="fa fa-fw fa-sitemap"></i>
            <span class="nav-link-text">Paramètres</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseMulti" style="">
            <li>
              <a href="#">Employés</a>
            </li>
            <li>
              <a href="#">Projets</a>
            </li>
            <li>
              <a href="#">Sprints</a>
            </li>
            <li>
              <a class="nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMulti2">Third Level</a>
              <ul class="sidenav-third-level collapse" id="collapseMulti2">
                <li>
                  <a href="#">Third Level Item</a>
                </li>
                <li>
                  <a href="#">Third Level Item</a>
                </li>
                <li>
                  <a href="#">Third Level Item</a>
                </li>
              </ul>
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
    <?php require_once 'api/www/Configs.php'; ?>
</body>