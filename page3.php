    <html>
    
        <?php
            include('header.php');
        ?>
        
        </br></br>
        
        <div class="container-fluid">
        
            <div class="row">
            
                <div class="col-sm-3"> 
                    
                    <form method="POST" action="EditerBdd\AjoutHeureDescendue.php">
                     
                        <!-- ///  AFFICHER LISTE SPRINT  /// -->
                        <div class="row">
                            <div class="col-sm-11">
                                <div class="form-group">
                                    <label for="sel1">Sprint n°</label>
                                        <select class="form-control"  id="sprintIdList" onchange='update();'>
                                            
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
                            </div>
                        </div>
                        
                        <!-- ///  AFFICHER LISTE Employe  /// -->
                        <div class="row">
                            <div class="col-sm-11">
                                <div class="form-group">
                                    <label for="sel1">Employe</label>   
                                        <select class="form-control"  name="employeid">
                                            
                                                <?php
                                                    $result = $conn->query("select id, prenom from employe");
                                                    
                                                    while ($row = $result->fetch_assoc()) {
                                                      unset($id, $nom);
                                                      $id = $row['id'];
                                                      $prenom = $row['prenom']; 
                                                      echo '<option value="'.$id.'"> ' .$prenom. ' </option>';
                                                    }                
                                                ?>
                                        </select>
                                </div>
                           </div>
                        </div>
                        
                        <!-- /// AFFICHER LISTE Projet  /// -->
                        <div class="row">
                            <div  class="col-sm-11">
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
                            </div>
                        </div>
                       
                        <!-- /// Nombre d'heures  /// -->
                        <div class="row">
                            <div class="col-sm-11">
                                <div class="input-group" >
                                    <span class="input-group-addon" >Nb Heures</span>
                                    <input type="number" class="form-control bfh-number" name="nbheure"  min=1 value=1 aria-describedby="basic-addon1" >       
                                </div>
                            </div>
                        </div>
                        
                        </br>
                        
                        <!-- ///  AFFICHER L'heure  /// -->
                        <div class="row">
                            <div class="col-sm-11"> 
                                <div class="form-group">
                                    <div class='input-group date'>
                                        <input type='text' placeholder="Date de Début"  name="dateDebut" id='dateDebut' class="form-control" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ///  AFFICHER bouton  /// -->
                        <div class="row">
                            <div class="col-md-11"> 
                                <button type="submit" class="btn btn-success btn-block">
                                    <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Ajouter
                                </button>
                            </div>
                        </div>
                   
                    </form>
                </div> 
                
                <div class="col-sm-6">
                
                    <h4><b>Heures descendue(s) par Employé(e), par Projet, par Jour</b></h4>
                    
                        <table id="datatable1" class="table table-striped table-bordered">
                 
                            <thead>
                                <tr>
                                    <th>Employé(e)</th>
                                    <th>Projet</th>
                                    <th>Heure(s)</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            
                        </table>
                        
                </div>
                
                <!--Total heures descendues par jour-->
                <div class="col-sm-3"  style="background-color: white;">
                
                    <h4><b>Heures descendue(s) par jour</b></h4>
                    
                        <table id="datatable2" class="table table-striped table-bordered">
                 
                            <thead>
                                <tr>
                                    <th>Heure(s)</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            
                        </table>
                        
                        <h4><b>Heures descendue(s) par jour</b></h4>
                    
                        <table id="datatable3" class="table table-striped table-bordered">
                 
                            <thead>
                                <tr>
                                    <th>total</th>
                                </tr>
                            </thead>
                            
                        </table>
                    
                </div>
                
            </div>
            
        </div>
        
        <script>
        
            //Script au lancement
            $(document).ready(function() {
                update();
            } );
                
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
                
            /////////// Fonction pour mettre à jours l'affichage
            var update = function(){
                
                x = parseInt($("#sprintIdList").val()); 
                
                var hdown = getdatafromurlNEW("http://localhost/ScrumManager/api/www/heuresdescendues/LaListeGeneral/"+x);
                var hdownperday = getdatafromurlNEW("http://localhost/ScrumManager/api/www/heuresdescendues/LaListeParJour/"+x);
                var hdowntotal = getdatafromurlNEW("http://localhost/ScrumManager/api/www/heuresdescendues/LaListeTotal/"+x);
                
                var heures = hdown[0];
                var date = hdownperday[1];
                var heuretotal = hdowntotal[0]
                
                var Leshdown = [];
                var LeshdownParJour = [];
                var LeshdownTotal = [];
                    
                for (i = 1; i < heures.length; i++) {
                    Leshdown.push({heure: hdown[0][i], date: hdown[1][i], projet: hdown[2][i], employe: hdown[3][i]});
                 }
                     
                for (i = 1; i < date.length; i++) {
                    LeshdownParJour.push({heure: hdownperday[0][i], date: hdownperday[1][i]});
                }
                
                LeshdownTotal.push({total: hdowntotal[0]});
                    
                console.log('Heure descendues convertie en objet js : ',Leshdown);
                console.log('Heure descendues groupé par jours convertie en objet js : ',LeshdownParJour);
                console.log('Heure descendues total convertie en objet js : ',LeshdownTotal);
                    
                $('#datatable1').DataTable({
                    "bDestroy": true,
                    data: Leshdown,
                    columns: [
                        { data: 'employe' },
                        { data: 'projet' },
                        { data: 'heure' },
                        { data: 'date' }
                    ]
                });
                
                $('#datatable2').DataTable({
                    "paging":   false,
                    "info":     false,
                    "bFilter":  false,
                    "bDestroy": true,
                    data: LeshdownParJour,
                    columns: [
                        { data: 'heure' },
                        { data: 'date' }
                    ]
                });
                
                $('#datatable3').DataTable({
                    "paging":   false,
                    "ordering":   false,
                    "info":     false,
                    "bFilter":  false,
                    "bDestroy": true,
                    data: LeshdownTotal,
                    columns: [
                        { data: 'total' }
                    ]
                });
                
            };
                
            //Donnée a l'objet datedebut le format de date
            $('#dateDebut').datetimepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                minView : 2
            });

            //Changer l'affichage de la date si possible erreur
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

    </html>