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
                    <i class="fa fa-plus"></i> Heure Descendue</div>
					<div class="card-body">
						<form>
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
								<label for="exampleInputEmail1">Numéro Sprint</label>
								<input class="form-control" id="exampleInputEmail1" type="number" placeholder="Le texte" min="1" value="1">
							</div>
                            
                            <div class="form-group">
										<label for="exampleInputName">Jours</label>
										<div class='input-group date'>
											<input type='text' placeholder="Date de Début"  name="dateDebut" id='dateDebut' class="form-control" />
											<span class="input-group-addon">
											<span class="fa fa-calendar"></span>
											</span>
										</div>
									</div>
                            
							<a class="btn btn-primary btn-block" href="login.html">Attribuer</a>
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
          <i class="fa fa-table"></i>  Heures descendue(s) par Employé(e), par Projet</div>
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
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i>  Heures descendue(s) par jour</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Heures</th>
                  <th>Date</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i>  Total d'heures descendues</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
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
$('#dateDebut').datetimepicker({
		    format: 'yyyy-mm-dd',
		    autoclose: true,
		    minView : 2
		});

function DateAujourdhui(_id){
		    var _dat = document.querySelector(_id);
		    var aujourdui = new Date(),
		        j = aujourdui.getDate()-1,
		        m = aujourdui.getMonth()+1, 
		        a = aujourdui.getFullYear(),
		        data;
		        
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
	</script>

</body>

</html>
