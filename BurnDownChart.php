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
				<div class="card-header">Sélection BurndownChart</div>
				<div class="card-body">
					<!-- Selectionner le sprint sur lequel l'on va jouer -->
					<div class="form-group row">
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
							<a class="btn btn-primary btn-block" href="#" id="bouttonPlus" onClick="ChangerSprint('-1')">+</a>
						</div>
						<div class="col-md-3">
							<a class="btn btn-primary btn-block" href="#" id="bouttonMoins" onClick="ChangerSprint('+1')">-</a>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-3">
							<label> Seuil </label>
							<input type="number" class="form-control" id="LeSeuilDansLeDiv" disabled></input>
						</div>
						<div class="col-md-3">
							<label> Total à descendre </label>
							<input type="number" class="form-control" id="GetTotalADescendre" disabled></input>
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
					<div id="container">
					<script>
						var createChartNEW = function(heures, dates, seuils, sprintou, NumeroduSprint){
							heures = heures.map(function (x) { 
								return parseInt(x, 10); 
							});
							
							seuils = seuils.map(function (x) { 
								return parseInt(x, 10); 
							});

							console.log("Les Informations : ",heures, dates, seuils, sprintou);

							new Highcharts.Chart({
								chart: {
									renderTo: 'container'
								},
								title:{
									text: 'BurnDownChart du Sprint n°'+NumeroduSprint
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
									name: 'Seuil (Interventions, ...)',
									data: seuils,
									color: 'red'
								}
								]
							});
						};

					</script>
					</div>
				</div>
			</div>
			<?php require_once __Dir__ . '/footer.php'; ?>

		</div>
		<script>

			$( document ).ready(function() {
				misajour($("#sprintIdList").val());//au lancement de la page, afficher la burndownchart avec le numero de la liste
			});

				var ChangerSprint = function(Changement){ //la fonction démarre et met dans "changement" soit 1 ou -1

					if (Changement != 0) //Detecte si le changement est fait par la liste ou les boutons, si par les boutons
					NumeroduSprint = ListIdSprint[ListIdSprint.indexOf(parseInt($("#sprintIdList").val()))+parseInt(Changement)]; //Nouveau sprint = Indexation du numero + argument de la fonction ChangerSprint

				else
					NumeroduSprint = parseInt($("#sprintIdList").val()); //sinon checker en fonction du nouveau numéro sélectionné par la liste

				misajour(NumeroduSprint);


			};


 function GetTotalADescendre() 
 {
  var action = "GetTotalADescendre";
  var NumeroSprint = $('#sprintIdList').val();
  $.ajax({
   url : "Modele/ActionBurnDownChart.php", 
   method:"POST", 
   data:{action:action, NumeroSprint:NumeroSprint}, 
   success:function(data){
   	data = data.replace(/\s+/g, '');
   	$("#GetTotalADescendre").val(data);
  }
});
}
				//Fonction pour bloquer les bouton de changement de sprints si on est au sprint minimum ou maximum ou entre
				var bloquerbouton = function(NumeroSprint){

					if(ListIdSprint[0] == NumeroSprint)
						document.getElementById("bouttonPlus").classList.add("disabled")
					else
						document.getElementById("bouttonPlus").classList.remove("disabled")

					if(ListIdSprint[ListIdSprint.length-1] == NumeroSprint)
						document.getElementById("bouttonMoins").classList.add("disabled")
					else
						document.getElementById("bouttonMoins").classList.remove("disabled")

				};

				var misajour = function(NumeroduSprint){

					bloquerbouton(NumeroduSprint);

					var result = getdatafromurlNEW("/<?php echo $ProjectFolderName ?>/api/www/burndownchart/getChart/"+NumeroduSprint);
					
					if(result == null){
						var AfficherRien = [0];
						createChartNEW(AfficherRien, AfficherRien, AfficherRien, AfficherRien, NumeroduSprint);
					}
					else{
						createChartNEW(result[0], result[1], result[2], result[3], NumeroduSprint);
					}

					GetTotalADescendre();

					$("#sprintIdList").val(NumeroduSprint);

					$("#LeSeuilDansLeDiv").val(parseInt(result[2][0]));


				};
				
			</script>
		</div>
	</body>
	</html>