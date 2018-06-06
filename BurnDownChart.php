<!DOCTYPE html>
<html lang="en">
<?php require_once __Dir__ . '/header.php'; ?>
<?php $req = $conn->query('SELECT numero as nummax from sprint where id = (SELECT max(id) FROM sprint)');
$data = $req->fetch_assoc();
?>
<body class="fixed-nav sticky-footer bg-dark" id="page-top">
	<div class="content-wrapper">
		<div class="container-fluid">
			<div class="card mb-3">
				<div class="card-header">Selection BurndownChart</div>
				<div class="card-body">
					<!-- Selectionner le sprint sur lequel l'on va jouer -->
					<div class="form-group">
						<div class="form-row">
							<div class="col-md-6">
								<select class="form-control"  id="sprintIdList" onchange='sprintIdListChanged();'>
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
								<a class="btn btn-primary btn-block" href="#" id="bouttonPlus1" onClick="plus1()">+</a>
							</div>
							<div class="col-md-3">
								<a class="btn btn-primary btn-block" href="#" id="bouttonMoins1" onClick="moins1()">-</a>
							</div>
						</div>
					</div>

				</div>
			</div>
			<!-- Area Chart Example-->
			<div class="card">
				<div class="card-header">
					<i class="fa fa-area-chart"></i> Area Chart Example
				</div>
				<div class="card-body">
					<div id="container" style="height: 600;margin-top:20px;width: 1300"></div>
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

			var bouttonMoins1 = document.getElementById("bouttonMoins1");
			var bouttonPlus1 = document.getElementById("bouttonPlus1")

				/// FONCTION POUR RECCUPERER LES DONNEES DEPUIS LE SELECT, LE METTRE DANS LE LIENS DE L'API ET LE METTRE LE RESULTAT DANS LES DIFFERENTES VARIABLE ///
				var misajour = function(){

					x = parseInt($("#sprintIdList").val())
					bloquerbouton();
					var result = getdatafromurlNEW("/<?php echo $ProjectFolderName ?>/api/www/burndownchart/getChart/"+x);
					var heures = result[0];
					var dates = result[1];
					var seuils = result[2];
					var sprintou = result[3];
					createChartNEW(heures, dates, seuils, sprintou);
					$("#sprintIdList").val(x);

				};
				
				/// Lors de l'appuis sur le bouton pour voir le sprint suivant ou précédent///
				var plus1 = function(number){

					var toto = ListIdSprint.indexOf(parseInt($("#sprintIdList").val()))-1;

					SprintSuperieure = ListIdSprint[toto];

					$("#sprintIdList").val(SprintSuperieure);

					var result = getdatafromurlNEW("/<?php echo $ProjectFolderName ?>/api/www/burndownchart/sprintExist/"+SprintSuperieure);

					UpdateOuNonChart(result);

				};
				
				//////////////////////////////////////////////////////////////////
				var moins1 = function(number){

					var toto = ListIdSprint.indexOf(parseInt($("#sprintIdList").val()))+1;

					SprintInferieur = ListIdSprint[toto];

					$("#sprintIdList").val(SprintInferieur);

				    var result = getdatafromurlNEW("/<?php echo $ProjectFolderName ?>/api/www/burndownchart/sprintExist/"+SprintInferieur); //check si le resultat est true ou false

				    UpdateOuNonChart(result);

				};
				
				//Fonction pour bloquer les bouton de changement de sprints si on est au sprint minimum ou maximum ou entre
				var bloquerbouton = function(){

					x = parseInt($("#sprintIdList").val());

					if(ListIdSprint[0] == x)
						bouttonPlus1.classList.add("disabled")
					else
						bouttonPlus1.classList.remove("disabled")

					if(ListIdSprint[ListIdSprint.length-1] == x)
						bouttonMoins1.classList.add("disabled")
					else
						bouttonMoins1.classList.remove("disabled")

					console.log('valeur de la list: ',x);
					console.log('valeur max: ',ListIdSprint[0])

				};
				
				//Fonction lorsque l'on choisie un nouveau sprint depuis la liste deroulante
				var sprintIdListChanged = function(){

					var x = parseInt($("#sprintIdList").val());

					var result = getdatafromurlNEW("/<?php echo $ProjectFolderName ?>/api/www/burndownchart/sprintExist/"+x);

					UpdateOuNonChart(result);

				};

				var UpdateOuNonChart = function(result){

					if (result)
						misajour();
					else
						alert('Ce sprint n\'a pas de données. Rien à afficher.');

					bloquerbouton();

				};
				
				misajour();
				
			</script>
		</div>
	</body>
	</html>