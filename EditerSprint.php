    <html>
    
        <?php
        include('header.php');
        ?>

        <div class="container">

            <div class="row">
                <div class="col-sm-11">
                    <div class="form-group">
                        <label for="sel1">Sprint n°</label>
                            <select class="form-control"  name="numerosprint">
                                
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
            
            <div class="row">
                <div class="col-md-11"> 
                    <button class="btn btn-success btn-block">
                        <span onclick=test() class="glyphicon glyphicon-upload" aria-hidden="true"></span> Ajouter
                    </button>
                </div>
            </div>
            
        </div>
                    
        <script>

         var test = function(){
             console.log('coucou');
             x = $("#numerosprint").val();
            
         };
         
        </script>
                    
    </html>