<body class="fixed-nav sticky-footer bg-dark" id="page-top">
	<div class="content-wrapper">
		<div class="container-fluid">

			<div class="row">
				<div class="card col-sm-3">
					<div class="card-body">

						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">Sprint n°</span>
							</div>
							<div id="ListSrint"></div>
						</div>

						<br>
						<h3><u>Informations</u></h3>
						<div id="DateSprint"></div>
						<div id="NbJoursRestants"></div>
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

				RemplirListSprint('ListSrint');
				MettreChartAJour($("#numeroSprint option:selected").text());//au lancement de la page, afficher la burndownchart avec le numero de la liste

			});

$( "#ListSrint" ).change(function() {
  MettreChartAJour($("#numeroSprint option:selected").text());
});


			function MettreChartAJour(NumeroSprint){

				var action = "GetLesInfosDeLaBurnDownChart";

				$.ajax({
					url : "Modele/ActionBurnDownChart.php", 
					method:"POST", 
					data:{action:action, NumeroSprint:NumeroSprint}, 
					success:function(Total){
						Total = JSON.parse(Total);


						console.log(Total[2])


						CreerLaChart(Total[0], Total[1], Total[2], Total[3], NumeroSprint);

						if(Total[4][0] == null)
							$("#TotalHAttribues").html("Total heures à descendre: <b>Inconnue</b>");
						else
							$("#TotalHAttribues").html("Total heures à descendre: <b>"+Total[4]+"h</b>");

							$("#Seuil").html("Seuil: <b>"+parseInt(Total[2][0])+"h</b>");

						if(typeof Total[0][0] == 'undefined')
							$("#TotalHResteADescendre").html("Heures restante à descendre: <b>Inconnue</b>");
						else
							$("#TotalHResteADescendre").html("Heures restante à descendre: <b>"+(Total[0][Total[0].length-1])+"h</b>");

						if((Total[2][0] == null ) || (typeof Total[0][0] == 'undefined'))
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

				idAffiche = parseInt($("#numeroSprint option:selected").text());
		        var action = "DateMinMax";
		        $.ajax({
		         url : "Modele/ActionDescendre2.php", 
		         method:"POST", 
		         data:{action:action, idAffiche:idAffiche}, 
		         success:function(data){

					$("#DateSprint").html("Date: <b>"+data[0] + "</b> > <b>" + data[1]+"</b>")

		         	if(data[1] > ChoixDate(0)){

		         	Fin = new Date(data[1]);
		         	Aujourdui = new Date();
		         	$("#NbJoursRestants").html("Nombre de jours restants: <b>"+Math.ceil((Fin - Aujourdui)/(1000*60*60*24))+"</b>");
		         	

		         	}
		         else
		         	$("#NbJoursRestants").html("Nombre de jours restants: <b>date dépassée</b>");

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