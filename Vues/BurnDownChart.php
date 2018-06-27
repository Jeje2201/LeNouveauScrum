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
				<div class="card col-sm-3">
					<div class="card-body">


						            <div class="input-group mb-12">
              <div class="input-group-prepend">
                <span class="input-group-text">Sprint n°</span>
              </div>
             <select class="form-control"  id="sprintIdList" onchange="misajour($('#sprintIdList').val())">
								<?php


								$result = $conn->query("select id, numero from sprint order by numero desc");

								while ($row = $result->fetch_assoc()) {
									unset($id, $numero);
									$id = $row['id'];
									$numero = $row['numero']; 
									echo '<option value="'.$numero.'">' .$numero. '</option>';
								}

								?>
							</select>
            </div>
						<!-- Selectionner le sprint sur lequel l'on va jouer -->

							
							<br>
					<h3><u>Informations</u></h3>
					<div id="TotalHAttribues"></div>
					<div id=Seuil></div>
					<div id="TotalHResteADescendre"></div>
					<div id="TotalHDescendueAvecSeuil"></div>
					<div id="TotalHDescendue"></div>
					<div id="BarDePourcentageDheureDescendue"></div>
				</div>
			</div>

	<!-- Area Chart Example-->
	<div class="card col-sm-9">
		<div class="card-body">
			<div id="EmplacementChart">
			</div>
		</div>
	</div>

</div>

</div>
<script>

	$( document ).ready(function() {
				misajour($("#sprintIdList").val());//au lancement de la page, afficher la burndownchart avec le numero de la liste
			});

				var misajour = function(NumeroduSprint){

					$("#sprintIdList").val(NumeroduSprint);

					var action = "GetLesInfosDeLaBurnDownChart";
					var NumeroSprint = $('#sprintIdList').val();

					$.ajax({
						url : "Modele/ActionBurnDownChart.php", 
						method:"POST", 
						data:{action:action, NumeroSprint:NumeroSprint}, 
						success:function(Total){
							Total = JSON.parse(Total);

							CreerLaChart(Total[0], Total[1], Total[2], Total[3], NumeroduSprint);

							if(Total[4][0] == null)
								$("#TotalHAttribues").html("Total heures à descendre: <b>Inconnue</b>");
							else
								$("#TotalHAttribues").html("Total heures à descendre: <b>"+Total[4]+"h</b>");

							if(typeof Total[2][0] == 'undefined')
								$("#Seuil").html("Seuil: <b>Inconnue</b>");
							else
								$("#Seuil").html("Seuil: <b>"+parseInt(Total[2][0])+"h</b>");
								
							if(typeof Total[0][0] == 'undefined')
								$("#TotalHResteADescendre").html("Heures restante à descendre: <b>Inconnue</b>");
							else
								$("#TotalHResteADescendre").html("Heures restante à descendre: <b>"+(Total[0][Total[0].length-1])+"h</b>");

							if((typeof Total[2][0] == 'undefined') || (typeof Total[0][0] == 'undefined'))
								$("#TotalHDescendueAvecSeuil").html("Heures restante à descendre (seuil compris): <b>Inconnue</b>");
							else
								$("#TotalHDescendueAvecSeuil").html("Heures restante à descendre (seuil compris): <b>"+((Total[0][Total[0].length-1])-(parseInt(Total[2][0])))+"h</b>");

								if((Total[4][0] == null) || (typeof Total[0][0] == 'undefined')){
								$("#TotalHDescendue").html("Heures déjà descendues: <b>Inconnue</b>");
								$("#BarDePourcentageDheureDescendue").html("");
								}
								else{
								$("#TotalHDescendue").html("Heures déjà descendues: <b>"+(Total[4]-Total[0][Total[0].length-1])+"h</b> soit:");
								$("#BarDePourcentageDheureDescendue").html('<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: '+((Total[4]-Total[0][Total[0].length-1])*100/Total[4])+'%; aria-valuenow="'+((Total[4]-Total[0][Total[0].length-1])*100/Total[4])+'" aria-valuemin="0" aria-valuemax="100">'+Math.round(((Total[4]-Total[0][Total[0].length-1])*100/Total[4]))+'%</div></div>');
								}
						}

					});					

				};

					function CreerLaChart(heures, dates, seuils, sprintou, NumeroduSprint){
						heures = heures.map(function (x) { 
							return parseInt(x, 10); 
						});

						seuils = seuils.map(function (x) { 
							return parseInt(x, 10); 
						});

						console.log("Les Informations : ",heures, dates, seuils, sprintou);

						new Highcharts.Chart({
							chart: {
								renderTo: 'EmplacementChart'
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
	</body>
	</html>