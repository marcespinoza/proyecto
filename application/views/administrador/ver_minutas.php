  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
       <h1>
        
        <small>Bienvenido Administrador : <?php echo$this->session->userdata('username') ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url()?>index.php/c_administrador"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Administrador</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
         

          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">

              <h3 class="box-title">Lista de Minutas</h3>

              
                <div class="form-group">
                       <label>Filtrar Minutas por :</label>
                       <br>

                        <label>Fecha Ingreso :</label>
                      <input type='text' value='' class='filter' data-column-index='0'> 
                
                                      
                        <label>Fecha Edición :</label>
                        <input type='text' value='' class='filter' data-column-index='1'>
                   
                
                        <label>Escribano :</label>
                        <input type='text' value='' class='filter' data-column-index='2'>
                  
                        <label>Matricula :</label>
                        <input type='text' value='' class='filter' data-column-index='3'> 



                  
                  </div>
                </form>


                   <div class="box-body table-responsive no-padding">               
                         <table id="min" class="table-bordered" style="display: none" >
                        <thead>
                          <tr> 
                          <th>Fecha Ingreso al Sistema</th>
                          <th>Fecha de Edición</th>
                          <th>Escribano</th> 
                          <th>Matricula</th>
                          <th>Operaciones</th>
                            
                          </tr>
                        </thead>

                        <tbody >
                            <?php 
                            foreach ($minutas as $mi){ 
                               $date=new DateTime($mi->fechaIngresoSys);
                              $date_formated=$date->format('d/m/Y ');
                               $dat2=new DateTime($mi->fechaEdicion);
                              $date_formated2=$date->format('d/m/Y ');
                         ?>
                            
                          <tr>
                            <td>  <?php  echo "$date_formated"; ?></td>
                            <td>  <?php  echo "$date_formated2"; ?></td>
                           <td>  <?php  echo "$mi->nomyap".'  '; ?> <button type="button"  class="btn btn-primary"  data-toggle="modal" onclick="ventana_escribano(<?php echo "$mi->idEscribano"; ?>)" href="#Escribano"> Ver</button></td></td>
                            <td>  <?php  echo "$mi->matricula"; ?></td>
                             <td>
                             <button type="button"  class="btn btn-warning"  data-toggle="modal" onclick="ventana_det(<?php echo "$mi->idMinuta"; ?>)" href="#Detalles"> Detalles</button>
                            <button type="button"  class="btn btn-success"  data-toggle="modal" onclick="ventana_estados(<?php echo "$mi->idMinuta"; ?>)" href="#Estados"> Estados</button>
                             

                            </td>
                            
                            


                          
                          
                           
                          </tr>

                          <?php
                        }
                        ?>
                       
                        </tbody>
                 </table>
                 </div>

                         <div class="modal" id="Escribano">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                 <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h3 class="modal-title" style="color:white" >Detalles Escribano</h3>
                                 </div>
                                 <div class="modal-body">
                                          <table class="table"  >
                                            <thead>
                                              <tr>
                                                <th>Nombre y Apellido</th>
                                                <th>Usuario</th>
                                                <th>DNI</th>
                                                <th>Matricula</th>
                                                 <th>Direccion</th>
                                                 <th>Email</th>
                                                 <th>Telefono</th>
                                                 <th>Estado de Aprobacion</th>
                                               </tr>
                                             </thead> 
                                               <tbody id="det_esc" >

                                              </tbody >
                                            </table >
                                     </div>

                                 <div class="modal-footer">
                                  <a href="" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                                 </div>
                              </div>
                            </div>
                          </div>

        
                         <div class="modal" id="Detalles">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                 <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h3 class="modal-title" style="color:white" >Detalles de Minuta</h3>
                                 </div>
                                 <div class="modal-body" id="det" >
                                           
                                     </div>

                                 <div class="modal-footer">
                                  <a href="" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                                 </div>
                              </div>
                            </div>
                          </div>

                         
                 <div class="modal" id="Estados">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                         <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h3 class="modal-title" style="color:white" >Aceptar Minuta</h3>
                         </div>
                         <div class="modal-body">
                         <label><h3>Estados de la Minuta</label></h3>
                               <br>
                               <br>
                               <table class="table"  >
                                            <thead>
                                              <tr>
                                                <th>Fecha de Estado</th>
                                                <th>Estado</th>
                                                <th>Motivo de Rechazo</th>
                                               <th>Operador</th>
                                                 
                                               </tr>
                                             </thead> 
                                               <tbody id="estados_min" >

                                              </tbody >
                                            </table >
                         </div>

                         <div class="modal-footer">
                          <a href="" class="btn btn-primary" onclick="aceptar()">Aceptar</a>
                         </div>
                      </div>
                    </div>
                  </div>


                      
                  <script type="text/javascript">
            
                   

                   $(document).ready(function(){

                    //crea la tabla
                    var dtable=$('#min').DataTable(
                        {
                           autoWidht:false,

                             language: {
                                "sProcessing":     "Procesando...",
                            "sLengthMenu":     "Mostrar _MENU_ Minutas",
                            "sZeroRecords":    "No se encontraron resultados",
                            "sEmptyTable":     "Ningúna Minuta encontrada",
                            "sInfo":           "Mostrando Minutas del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix":    "",
                            "sSearch":         "Buscar:",
                            "sUrl":            "",
                            "sInfoThousands":  ",",
                            "sLoadingRecords": "Cargando...",
                            "oPaginate": {
                                "sFirst":    "Primero",
                                "sLast":     "Último",
                                "sNext":     "Siguiente",
                                "sPrevious": "Anterior"
                              }},
                                } );
                           

                    //para el filtrado
                     $('.filter').on('keyup change', function () {
                          //clear global search values
                          dtable.search('');
                          dtable.column($(this).data('columnIndex')).search(this.value).draw();
                      });
                      
                      $( ".dataTables_filter input" ).on( 'keyup change',function() {
                       //clear column search values
                          dtable.columns().search('');
                         //clear input values
                         $('.filter').val('');
                    }); 

                      //quitar el campo de busqueda por defecto
                      document.getElementById('min_filter').style.display='none';

                       $( "#min" ).show();
                  



                      var dtable2=$('#estados_mim').DataTable(
                        {
                           autoWidht:false,


                             language: {
                                "sProcessing":     "Procesando...",
                            "sLengthMenu":     "Mostrar _MENU_ Estados",
                            "sZeroRecords":    "No se encontraron resultados",
                            "sEmptyTable":     "Ningún Estado Encontrado",
                            "sInfo":           "Mostrando Estados del _START_ al _END_ de un total de _TOTAL_ registros",
                            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                            "sInfoPostFix":    "",
                            "sSearch":         "Buscar:",
                            "sUrl":            "",
                            "sInfoThousands":  ",",
                            "sLoadingRecords": "Cargando...",
                            "oPaginate": {
                                "sFirst":    "Primero",
                                "sLast":     "Último",
                                "sNext":     "Siguiente",
                                "sPrevious": "Anterior"
                              }},
                                } );
                          document.getElementById('estados_min_filter').style.display='none';
                  
                    } );
                    
                      function ventana_escribano( idEscribano){
                    $.post("<?=base_url()?>index.php/c_operador/detalles_esc",{idEscribano:idEscribano}, function(data){
                      $("#det_esc").html(data);
            });
                        }

                    function ventana_det(idMinuta){
                    $.post("<?=base_url()?>index.php/c_operador/detalles_minuta",{idMinuta:idMinuta}, function(data){
                      $("#det").html(data);
            });
                  }
                    function ventana_estados(idMinuta){
                    $.post("<?=base_url()?>index.php/c_operador/ver_estados",{idMinuta:idMinuta}, function(data){
                      $("#estados_min").html(data);
                      $("#minuta").html(idMinuta);
            });
                  }
                  


             
                  


                
                  
         </script>

           
          </div>
          <!-- /.box -->

       

        </section>
        <!-- /.Left col -->
      
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->