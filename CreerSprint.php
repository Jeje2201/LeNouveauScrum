<!DOCTYPE html>
<html lang="en">
<!-- Obtenir le nombre de sprint -->
<?php include('header.php'); ?>
<?php $req = $conn->query('SELECT numero as nummax from sprint where id = (SELECT max(id) FROM sprint)');
$data = $req->fetch_assoc();
?>
<body class="fixed-nav sticky-footer" id="page-top">
	<div class="content-wrapper">
		<div class="container">
			<div class="card card-register mx-auto mt-5">
				<div class="card-header">Créer un Sprint</div>
				<div class="card-body">
					<form method="POST" role="form" action="EditerBdd\AjoutSprint.php">
						<!-- Numero du nouveau sprint -->
						<div class="form-group">
							<label for="exampleInputEmail1">Numéro Sprint</label>
							<input class="form-control" id="numero" name="numero" type="number" aria-describedby="emailHelp" placeholder="Le texte" min="<?php echo $data['nummax']+1; ?>" max="<?php echo $data['nummax']+1; ?>" value="<?php echo $data['nummax']+1; ?>">
						</div>
						<div class="form-group">
							<div class="form-row">
								<!-- Heure de début -->
								<div class="col-md-6">
									<label for="exampleInputName">Heure de Début</label>
									<div class='input-group date'>
										<input type='text' placeholder="Date de Début"  name="dateDebut" id='dateDebut' class="form-control" />
										<span class="input-group-addon">
											<span class="fa fa-calendar"></span>
										</span>
									</div>
								</div>
								<!-- Heure de fin -->
								<div class="col-md-6">
									<label for="exampleInputLastName">Heure de Fin</label>
									<div class='input-group date'>
										<input type='text' placeholder="Date de Début"  name="dateFin" id='dateFin' class="form-control" />
										<span class="input-group-addon">
											<span class="fa fa-calendar"></span>
										</span>
									</div>
								</div>
							</div>
						</div>
						<button type="submit" class="btn btn-primary btn-block">
							<span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Créer
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php require_once __Dir__ . '/footer.php'; ?>
	<script>

		//Creation du format des datatimepicker avec un format ok pour l'insertion dans la bdd, un close auto lorsque l'on choisie la date et un view a 2 car on a pas besoin de plus.
		$('#dateDebut').datetimepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			minView : 2
		});
		$('#dateFin').datetimepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			minView : 2
		});

		DateAujourdhui("#dateDebut");
		DateApres("#dateFin");

		//Fonction pour auto remplir la date d'aujourd'hui dans le premier input date
		function DateAujourdhui(_id){
			var _dat = document.querySelector(_id);
			var aujourdui = new Date(),
			j = aujourdui.getDate(),
			m = aujourdui.getMonth()+1, 
			a = aujourdui.getFullYear();

			Ajouter0JoursMois(j,m,a,_dat)
		};

		//Mettre le deuxieme datapicker à 14jours après la date d'aujourd'hui.
		function DateApres(_id){
			var _dat = document.querySelector(_id);
			var Apres = new Date();
			Apres.setDate(Apres.getDate()+14);
			j = Apres.getDate(),
			m = Apres.getMonth()+1, 
			a = Apres.getFullYear();

			Ajouter0JoursMois(j,m,a,_dat)
		};
		
		function Ajouter0JoursMois(j,m,a,_dat){
			if(j < 10){
				j = "0" + j;
			};
			if(m < 10){
				m = "0" + m;
			};

			_dat.value = a + "-" + m + "-" + j;
		}

	</script>
</body>
</html>