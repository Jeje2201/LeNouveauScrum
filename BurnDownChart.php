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
								<select class="form-control"  id="sprintIdList" onchange='ChangerSprintList();'>
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
								<a class="btn btn-primary btn-block" href="#" id="bouttonPlus1" onClick="ChangerSprintBouton('-1')">+</a>
							</div>
							<div class="col-md-3">
								<a class="btn btn-primary btn-block" href="#" id="bouttonMoins1" onClick="ChangerSprintBouton('+1')">-</a>
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

				//Fonction appelé lors du changement d'un sprint avec les boutons plus et moins
				var ChangerSprintBouton = function(Changement){ //la fonction démarre et met dans "changement" soit 1 ou -1

					NumeroduSprint = ListIdSprint[ListIdSprint.indexOf(parseInt($("#sprintIdList").val()))+parseInt(Changement)]; //Prend la valeur du prochain numéro de sprint en regardant la valeur de l'indice +1 ou -1 de la list, donc soit le numéro du précédent ou suivant sprint dans la liste

					$("#sprintIdList").val(NumeroduSprint); //Donne a la liste ce numéro

				    var result = getdatafromurlNEW("/<?php echo $ProjectFolderName ?>/api/www/burndownchart/sprintExist/"+NumeroduSprint); //Regarde si le sprint existe ou non dans la bdd

				    UpdateOuNonChart(result, NumeroduSprint); //Appel la fonction pour regarder si elle existe ou non et déduire quoi faire

				};
				
				//Fonction lorsque l'on choisie un nouveau sprint depuis la liste deroulante
				var ChangerSprintList = function(){

					var NumeroduSprint = parseInt($("#sprintIdList").val());

					var result = getdatafromurlNEW("/<?php echo $ProjectFolderName ?>/api/www/burndownchart/sprintExist/"+NumeroduSprint);

					UpdateOuNonChart(result, NumeroduSprint);

				};

				var UpdateOuNonChart = function(result, NumeroduSprint){

					if (result)
						misajour();
					else{
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
				var misajour = function(){

					NumeroSprint = parseInt($("#sprintIdList").val())
					bloquerbouton(NumeroSprint);
					var result = getdatafromurlNEW("/<?php echo $ProjectFolderName ?>/api/www/burndownchart/getChart/"+NumeroSprint);
					var heures = result[0];
					var dates = result[1];
					var seuils = result[2];
					var sprintou = result[3];
					createChartNEW(heures, dates, seuils, sprintou);
					$("#sprintIdList").val(NumeroSprint);

				};
				
				misajour();
				
			</script>
		</div>
	</body>
	</html>