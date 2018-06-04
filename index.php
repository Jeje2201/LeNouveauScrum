    <html class="bg">
        <?php include('header.php'); 
        
        $req = $conn->query('SELECT numero as nummax from sprint where id = (SELECT max(id) FROM sprint)');
        $data = $req->fetch_assoc();
        ?>

        </br></br></br></br></br></br></br></br></br>

        <form method="POST" role="form" action="InsertionBdd\AjoutSprint.php">

            <div class="container">

                <!-- L'input avec le bon numero du nouveau sprint -->
                <div class="row">
                <div class="col-sm-4"></div>
                        <div class="col-sm-2">
                            <div class="input-group" >
                              <span class="input-group-addon" >Sprint n°</span>
                              <input type="number" class="form-control bfh-number" name="numero" id="numero"  min="<?php echo $data['nummax']+1; ?>" max="<?php echo $data['nummax']+1; ?>" value="<?php echo $data['nummax']+1; ?>" aria-describedby="basic-addon1">
                            </div>
                       </div>
                </div>

                </br></br></br>

                <!-- Les date time picker -->
                <div class="row">
                <div class="col-sm-2"></div> 
                    <div class='col-md-3'>
                        <div class="form-group">
                            <div class='input-group date'>
                                <input type='text' placeholder="Date de Début"  name="dateDebut" id='dateDebut' class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class="form-group">
                            <div class='input-group date' >
                                <input type='text' placeholder="Date de Fin"  name="dateFin" id='dateFin' class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                </br></br>
                
                <!-- Le Boutton submit -->
                    <div class="row">
                    <div class="col-sm-4"></div>
                        <div class="col-sm-2"> 
                            <button type="submit" class="btn btn-success btn-block">
                              <span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Créer
                            </button>
                        </div>
                    </div>
                    
            </div>
            
        </form>

        <script>
        
             //Creation du format des datatimepicker avec un format ok pour l'insertion dans la bdd, un close auto lorsque l'on choisie la date et un view a 2 car on a pas besoin de plus.
             $('#dateDebut').datetimepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    minView : 2
             });
             $('#dateFin').datetimepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    minView : 2
             });

            //Fonction pour auto remplir la date d'aujourd'hui dans le premier input date
            function DateAujourdhui(_id){
                var _dat = document.querySelector(_id);
                var aujourdui = new Date(),
                    j = aujourdui.getDate(),
                    m = aujourdui.getMonth()+1, 
                    a = aujourdui.getFullYear(),
                    data;
                    
                //si jour ou mois inferrieur a 10 genre "1" il doit avoir un "0" avant pour que le date soit dans un format valide.   
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

            //Mettre le deuxieme datapicker à 14jours après la date d'aujourd'hui.
            function DateApres(_id){
                var _dat = document.querySelector(_id);
                var Apres = new Date(),
                    j = Apres.getDate()+14,
                    m = Apres.getMonth()+1, 
                    a = Apres.getFullYear(),
                    data;
                
                //Si l'on dépasse 31jours avec le bon mois, faire le calcule.
                if((m == 1) || (m == 3) || (m == 5) || (m == 7) || (m == 9) || (m == 11) ) {  
                    if(j > 31){ console.log('Jour avant le changement : ' + j + '  car "jour du début" + 27'); console.log('Mois avant le changement : ' + m + ' (impair donc 31 jours compris)');
                    console.log('-- Passage au prochain mois --');
                        j -= 31; console.log('Jour après le changement : ' + j )
                        m += 1;   console.log('Mois après le changement : ' + m + '  (soit +1 car nouveau mois)')      
                    }
                }
                    else{ 
                       if(j > 30){  console.log('Jour avant le changement : ' + j ); console.log('Mois avant le changement : ' + m + ' (pair donc 30 jours compris)'); 
                           console.log('-- Passage au prochain mois --');
                        j -= 30; console.log('Jour après le changement : ' + j )
                        m += 1;  console.log('Mois après le changement : ' + m + '  (soit +1 car nouveau mois)')            
                    };
                }; 
                
                //si mois dépasse 12 alors passer à l'année prochaine et remettre le bon mois.
                if(m > 12){
                  m -= 12;
                  y += 1;
                };
                
                if(j < 10){
                    j = "0"+j;
                };
                
                if(m < 10){
                    m = "0"+m;
                };

                data = a + "-" + m + "-" + j;
                _dat.value = data;
            };
            
            DateApres("#DateFin");

        </script>

    </html>