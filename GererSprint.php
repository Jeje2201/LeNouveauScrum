<!DOCTYPE html>
<html lang="en">
<?php require_once __Dir__ . '/header.php'; ?>
<body class="fixed-nav sticky-footer bg-dark" id="page-top">
	<div class="content-wrapper">
		<div class="container-fluid">
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-body" id="InterieurDeLalert">
						</div>
					</div>
				</div>
			</div>
			<div class="card mb-3">
				<div class="card-header">Gérer Sprint</div>
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

				</div>
			</div>

			<div class="col-md-3">
				<button  class="btn btn-primary" onClick="Set()">Sauvegarder</button>
			</div>

			<?php require_once __Dir__ . '/footer.php'; ?>

		</div>
		<script>


</script>
</body>
</html>