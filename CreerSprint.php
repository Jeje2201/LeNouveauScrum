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
		
		//Fonction pour auto remplir la date d'aujourd'hui dans le premier input date
		function DateAujourdhui(_id){
		var _dat = document.querySelector(_id);
		var aujourdui = new Date(),
		j = aujourdui.getDate(),
		m = aujourdui.getMonth()+1, 
		a = aujourdui.getFullYear(),
		data;
		
		//si jour ou mois inferrieur a 10 genre "1" il doit avoir un "0" avant pour que le date soit dans un format valide.   
		if(j < 10){
		j = "0" + j;
		};
		if(m < 10){
		m = "0" + m;
		};
		data = a + "-" + m + "-" + j;
		_dat.value = data;
		};
		DateAujourdhui("#dateDebut");
		
		//Mettre le deuxieme datapicker à 14jours après la date d'aujourd'hui.
		function DateApres(_id){
		var _dat = document.querySelector(_id);
		var Apres = new Date(),
		j = Apres.getDate()+14,
		m = Apres.getMonth()+1, 
		a = Apres.getFullYear(),
		data;
		
		//Si l'on dépasse 31jours avec le bon mois, faire le calcule.
		if(m == (1||3||5||7||8||10||12)) {  
		if(j > 31){
		j -= 31;
		m += 1;     
		}
		}
		else{ 
		if(j > 30){
		j -= 30; 
		m += 1;      
		};
		}; 
		
		//si mois dépasse 12 alors passer à l'année prochaine et remettre le bon mois.
		if(m > 12){
		m -= 12;
		y += 1;
		};
		
		if(j < 10){
		j = "0"+j;
		};
		
		if(m < 10){
		m = "0"+m;
		};
		
		data = a + "-" + m + "-" + j;
		_dat.value = data;
		};
		
		DateApres("#dateFin");
		
	</script>
    </body>
</html>