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
				<div class="card-header">Selection BurndownChart</div>
				<div class="card-body">
					<!-- Selectionner le sprint sur lequel l'on va jouer -->
					<div class="form-group">
						<div class="form-row">
							<div class="col-md-6">
								<select class="form-control"  id="sprintIdList" onchange="ChangerSprint('0')">
									<?php

									echo '<script> var ListIdSprint =[]; </script>';

									$result = $conn->query("select id, numero from sprint order by numero desc");

									while ($row = $result->fetch_assoc()) {
										unset($id, $numero);
										$id = $row['id'];
										$numero = $row['numero']; 
										echo '<option value="'.$numero.'">' .$numero. '</option>
										<script> ListIdSprint.push('.$numero.'); </script>';
									}

									echo'<script>console.log("liste complete de numero de sprint: ", ListIdSprint);</script>';

									?>
								</select>
							</div>

							<div class="col-md-3">
								<a class="btn btn-primary btn-block" href="#" id="bouttonPlus1" onClick="ChangerSprint('-1')">+</a>
							</div>
							<div class="col-md-3">
								<a class="btn btn-primary btn-block" href="#" id="bouttonMoins1" onClick="ChangerSprint('+1')">-</a>
							</div>
						</div>
					</div>

				</div>
			</div>
			<!-- Area Chart Example-->
			<div class="card">
				<div class="card-header">
					<i class="fa fa-area-chart"></i>
				</div>
				<div class="card-body">
					<div id="container"></div>
					<script>
						var createChartNEW = function(heures, dates, seuils, sprintou){
							heures = heures.map(function (x) { 
								return parseInt(x, 10); 
							});
							
							seuils = seuils.map(function (x) { 
								return parseInt(x, 10); 
							});

							var x = $("#sprintIdList").val();

							console.log("Les Informations : ",heures, dates, seuils, sprintou);

							new Highcharts.Chart({
								chart: {
									renderTo: 'container'
								},
								title:{
									text: 'BurnDownChart du Sprint n°'+x
								},
								subtitle:{
									text: document.ontouchstart === undefined ?
									'Déplace ta souris sur les points pour avoir plus de détails': ''
								},
								yAxis: {
									min: 0,
									title: {
										text: 'Heures'
									}
								},
								xAxis: {
									type: 'datetime',
									categories: dates
								},
								series: [{
									name: 'Heures Restantes',
									data: heures
								},
								{
									name: 'Seuil',
									data: seuils,
									color: 'red'
								}
								]
							});
						};

					</script>
				</div>
			</div>
			<?php require_once __Dir__ . '/footer.php'; ?>

		</div>
		<script src="js/getdataformulNEW.js"></script>
		<script>

				//Fonction appelée lors du changement d'un sprint
				var ChangerSprint = function(Changement){ //la fonction démarre et met dans "changement" soit 1 ou -1

					if (Changement != 0){ //Detecte si le changement est fait par la liste ou les boutons, si par les boutons
					NumeroduSprint = ListIdSprint[ListIdSprint.indexOf(parseInt($("#sprintIdList").val()))+parseInt(Changement)]; //Nouveau sprint = Indexation du numero + argument de la fonction ChangerSprint
					$("#sprintIdList").val(NumeroduSprint); //Donne a la liste ce numéro
					}

					else
					NumeroduSprint = parseInt($("#sprintIdList").val()); //sinon checker en fonction du nouveau numéro sélectionné par la liste

				    var result = getdatafromurlNEW("/<?php echo $ProjectFolderName ?>/api/www/burndownchart/sprintExist/"+NumeroduSprint); //Regarde si le sprint existe ou non dans la bdd

					if (result) //si il existe, mettre a jours la bdd
						misajour(NumeroduSprint);
					
					else{ //sinon popup indiquant aucun résultat
						$('#myModal').modal('show');
    					$('#InterieurDeLalert').text('Sprint n°'+NumeroduSprint+' manque de données 💩');
    					bloquerbouton(NumeroduSprint);
					}

				};

				//Fonction pour bloquer les bouton de changement de sprints si on est au sprint minimum ou maximum ou entre
				var bloquerbouton = function(NumeroSprint){

					if(ListIdSprint[0] == NumeroSprint)
						document.getElementById("bouttonPlus1").classList.add("disabled")
					else
						document.getElementById("bouttonPlus1").classList.remove("disabled")

					if(ListIdSprint[ListIdSprint.length-1] == NumeroSprint)
						document.getElementById("bouttonMoins1").classList.add("disabled")
					else
						document.getElementById("bouttonMoins1").classList.remove("disabled")

				};

				/// FONCTION POUR RECCUPERER LES DONNEES DEPUIS LE SELECT, LE METTRE DANS LE LIENS DE L'API ET LE METTRE LE RESULTAT DANS LES DIFFERENTES VARIABLE ///
				var misajour = function(NumeroduSprint){

					bloquerbouton(NumeroduSprint);
					var result = getdatafromurlNEW("/<?php echo $ProjectFolderName ?>/api/www/burndownchart/getChart/"+NumeroduSprint);
					var heures = result[0];
					var dates = result[1];
					var seuils = result[2];
					var sprintou = result[3];
					createChartNEW(heures, dates, seuils, sprintou);
					$("#sprintIdList").val(NumeroduSprint);

				};
				
				misajour($("#sprintIdList").val());
				
			</script>
		</div>
	</body>
	</html>