<body class="fixed-nav sticky-footer bg-dark" id="page-top">
	<div class="content-wrapper">
		<div class="container-fluid">
			<div class="card mb-3">
				<div class="card-header">Paramètres</div>
				<div class="card-body">
					<!-- Selectionner le sprint sur lequel l'on va jouer -->

					<div class="form-group">
						<label for="exampleInputEmail1">Nombre de jours pour 1 sprint</label>
						<input type="number" class="form-control" name="NbJoursParSprint" id="NbJoursParSprint" value="14" min="1">
						<small class="form-text text-muted">Exemple; "14" veut dire qu'un sprint aura une durée de 14 jours.</small>
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Nombre d'heures disponibles pour un Sprint par employé(e)</label>
						<input type="number" class="form-control" id="NbHeureDisponibleParSprint" value="60" min="1">
						<small class="form-text text-muted">Exemple; "60" veut dire que chaque employé pourra travailler un maximum de 60 heures pour un sprint</small>
					</div>

					<div class="form-group">
						<label for="exampleInputEmail1">Temps affichage popup</label>
						<input type="number" class="form-control" id="TempsAffichagePopup" step='0.1' value="1.5" min="0.5">
						<small class="form-text text-muted">Exemple; "1,5" veut dire que la popup ne s'affichera que 1,5s</small>
						<button  class="btn btn-primary" onClick="Popup()">Tester</button>
					</div>

				</div>
			</div>

			<div class="col-md-3">
				<button  class="btn btn-primary" onClick="Set()">Sauvegarder</button>
			</div>

			<?php require_once __Dir__ . '/footer.php'; ?>

		</div>
		<script>

			function Popup(){ 
				Set();
BootstrapAlert('Je suis un test :D');
		};

			var Set = function(){ //la fonction démarre et met dans "changement" soit 1 ou -1
			localStorage.setItem("NbJoursParSprint",$('#NbJoursParSprint').val());
			localStorage.setItem("TempsAffichagePopup",$('#TempsAffichagePopup').val()*1000);

		};

	</script>