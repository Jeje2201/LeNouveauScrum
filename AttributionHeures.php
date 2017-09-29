<!DOCTYPE html>
<html lang="en">
	<?php require_once __Dir__ . '/header.php'; ?>
    
	<body class="fixed-nav sticky-footer bg-dark" id="page-top">
		<!-- Navigation-->
		<div class="content-wrapper">
			<div class="container-fluid">
				<!-- Phase de selection pour l'ajout-->
                
				<div class="card mb-3">
					<div class="card-header">
						<i class="fa fa-plus"></i> Attribution Heure
					</div>
					<div class="card-body">
						<form method="POST" action="EditerBdd\AjoutHeureAttribution.php">
							<div class="form-group">
								<label for="sel1">Sprint n°</label>
								<select class="form-control"  id="sprintIdList" name="sprintIdList" onchange='update();'>
								<?php
									$result = $conn->query("select id, numero from sprint order by id desc");
									
									                while ($row = $result->fetch_assoc()) {
									                              unset($id, $numero);
									                              $id = $row['id'];
									                              $numero = $row['numero']; 
									                              echo '<option value="'.$id.'"> ' .$numero. ' </option>';
									                }
									?> 
								</select>
							</div>
							<div class="form-group">
								<label for="sel1">Projet</label>
								<select class="form-control"  name="projetid">
								<?php
									$result = $conn->query("select id, nom from projet");
									    
									
									        while ($row = $result->fetch_assoc()) {
									          unset($id, $nom);
									          $id = $row['id'];
									          $nom = $row['nom']; 
									          echo '<option value="'.$id.'"> ' .$nom. ' </option>';
									        }
									?>
								</select>
							</div>
							<div class="form-group">
								<?php
									$result = $conn->query("select id, prenom from employe");
									echo "<label for=\"sel1\">Employe</label>";    
									    echo "<select class=\"form-control\"  name=\"employeid\">";
									        while ($row = $result->fetch_assoc()) {
									          unset($id, $nom);
									          $id = $row['id'];
									          $prenom = $row['prenom']; 
									          echo '<option value="'.$id.'"> ' .$prenom. ' </option>';
									        }
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Nombres d'heures</label>
								<input class="form-control" name="nbheure" type="number" placeholder="Le texte" min="1" value="1">
							</div>
							<button type="submit" class="btn btn-primary btn-block">
							<span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Attribuer
							</button>
						</form>
						<!--
							<div class="text-center">
							  <a class="d-block small mt-3" href="login.html">Login Page</a>
							  <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
							</div>
							-->
					</div>
				</div>
				<!-- Example DataTables Card-->
				<div class="card mb-3">
					<div class="card-header">
						<i class="fa fa-table"></i>  Heures attribuée(s) par Employé(e), par Projet
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
								<thead>
									<tr>
										<th>Employé</th>
										<th>Projet</th>
										<th>Heure</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
				<!-- Table total heures -->
				<div class="card mb-3">
					<div class="table-responsive">
						<table class="table table-bordered" id="datatable2" width="100%" cellspacing="0">
							<thead>
								<tr>
									<th>Total</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
			<!-- /.container-fluid-->
			<!-- /.content-wrapper-->
		</div>
        
		<?php require_once __Dir__ . '/footer.php'; ?>
		<script>
			/////////// Attrapper les infos de la requete sql
				var getdatafromurlNEW = function(myurl)
				{
				    var exist = null;
				    console.log("getdatafromurlNEW", myurl);
				    $.ajax({
				        url: myurl,
				        async: false,
				        success: function(result){
				            exist = result;
				        },
				        error: function(xhr){
				            console.log("error NEW", xhr);
				            
				        }
				    });
				    return (exist);
				};
				
				/////////// Fonction pour mettre à jour l'affichage
				var update = function(){  
				x = parseInt($("#sprintIdList").val()); // x prend la valeur du nombre selectionner depuis la liste deroulante affichant tout les sprints
				
				var hatt = getdatafromurlNEW("http://localhost/LeNouveauScrum/api/www/action/gethouratt/"+x); // la variable hatt prend le resultat de la requette qui renvoit les h attribuées tout sous forme de 3 tableaux
				var tothatt = getdatafromurlNEW("http://localhost/LeNouveauScrum/api/www/action/gettothouratt/"+x);
				
				var counter = hatt[2]; //créer un timer qui prendre comme valeur le nombre de resultat d'un des 3 tableau obtenue au par avant
				
				var Lehatt = []; //créer un talbeau
				var Letothatt = [];
				
				for (i = 0; i < counter.length; i++) { //boucle qui tourne le nombre de fois qu'il y a de resultat
				    Lehatt.push({name: hatt[0][i], project: hatt[1][i], hours: hatt[2][i]}); //Creer un objet général qui aura différent objets, chacun prenant 1 valeur des different tableau, l'objet "1" prendre les infos "1" de chaque tableau
				}
				 
				Letothatt.push({tot: tothatt[0]}); //notre variable total d'heure n'affiche qu'une heure ( le total ) donc pas de loop
				
				console.log('Une fois heure attribue convertie en objet js : ',Lehatt); //log les resultat pour checker les infos
				console.log('Une fois total heure attribue convertie en objet js : ',Letothatt);  //log les resultat pour checker les infos
				
				$('#datatable').DataTable({   //dire que la table est une datatable ( grace au plugin DataTables)
				    "bDestroy": true, //lui permettre de se détruire pour en afficher une nouvelle quand on selectionne un nouveau sprint
				    data: Lehatt, //lui dire que les données viennent de quelle variable
				    columns: [
				        { data: 'name' }, //lui donner pour chaque colonne le nom de la catégorie des objets
				        { data: 'project' },
				        { data: 'hours' }
				    ]
				});
				$('#datatable2').DataTable({
				    "paging":   false,
				    "ordering": false,
				    "info":     false,
				    "bFilter": false,
				    "bDestroy": true,
				    data: Letothatt,
				    columns: [
				        { data: 'tot' }
				    ]
				});
				   
				};
				
				/////////// Au premier lancement de la page
				$(document).ready(function() {
				    update();
				} );
				            
		</script>
	</body>
</html>