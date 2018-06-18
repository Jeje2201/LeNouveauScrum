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
			<div class="row">
				<div class="card col-sm-6">
					<div class="card-header"><i class="fa fa-search" aria-hidden="true"></i> Sélection</div>
					<div class="card-body">
						<!-- Selectionner le sprint sur lequel l'on va jouer -->
						<div class="form-group row">
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
						<div class="row">
							<a class="btn btn-primary btn-block" href="#" id="bouttonPlus" onClick="ChangerSprint('-1')">+</a>
							
						</div>
					</br>
					<div class="row">
						<a class="btn btn-primary btn-block" href="#" id="bouttonMoins" onClick="ChangerSprint('+1')">-</a>
						
					</div>
					
					
				</div>
			</div>

			<div class="card col-sm-6">
				<div class="card-header"><i class="fa fa-eye"></i> Informations</div>
				<div class="card-body">
					<div id=Seuil></div>
					<div id="TotalHAttribues"></div>
					<div id="TotalHResteADescendre"></div>
					<div id="TotalHDescendue"></div>
					<div id="BarDePourcentageDheureDescendue"></div>

					

				</div>
			</div>
		</div>

	</div>
	<!-- Area Chart Example-->
	<div class="card">
		<div class="card-header">
			<i class="fa fa-area-chart"></i>
			Affichage
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
							plotOptions: {
								line: {
									dataLabels: {
										enabled: true
									},
									enableMouseTracking: true
								}
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

					$("#sprintIdList").val(NumeroduSprint);


					var action = "GetLesInfosDeLaBurnDownChart";
					var NumeroSprint = $('#sprintIdList').val();

					$.ajax({
						url : "Modele/ActionBurnDownChart.php", 
						method:"POST", 
						data:{action:action, NumeroSprint:NumeroSprint}, 
						success:function(Total){
							Total = JSON.parse(Total);

							createChartNEW(Total[0], Total[1], Total[2], Total[3], NumeroduSprint);

							if(Total[0][Total[0].length-1] == undefined){
								$("#Seuil").html("Aucune information disponible.. 💩");

								$("#TotalHAttribues").html("");

								$("#TotalHResteADescendre").html("");

								$("#TotalHDescendue").html("");

								$("#BarDePourcentageDheureDescendue").html("");

								$("#container").html("Aucune chart à afficher.. 💩");
							}
							else{
								console.log('ah bah oui');
								$("#Seuil").html("Seuil: <b>"+parseInt(Total[2][0])+"h</b>");

								$("#TotalHAttribues").html("Total heures à descendre: <b>"+Total[4]+"h</b>");

								$("#TotalHResteADescendre").html("Heures restante à descendre: <b>"+(Total[0][Total[0].length-1])+"h</b>");

								$("#TotalHDescendue").html("Heures déjà descendues: <b>"+(Total[4]-Total[0][Total[0].length-1])+"h</b> soit <b>"+Math.round(((Total[4]-Total[0][Total[0].length-1])*100/Total[4]))+'%</b>');

								$("#BarDePourcentageDheureDescendue").html('<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: '+((Total[4]-Total[0][Total[0].length-1])*100/Total[4])+'%; height: 36px; aria-valuenow="'+((Total[4]-Total[0][Total[0].length-1])*100/Total[4])+'" aria-valuemin="0" aria-valuemax="100">');

							}

							
						}


					});					

				};
				
			</script>
		</div>
	</body>
	</html>