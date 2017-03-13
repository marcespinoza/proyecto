<!-- Content Wrapper. Contains page content -->
<style type="text/css">
 
</style>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
        
        <small>Bienvenido Administrador: <?php echo$this->session->userdata('username') ?></small>
      </h1>
 
   <ol class="breadcrumb">
      <li><a  href="<?=base_url()?>index.php/c_administrador"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Crear Operador</li>
   </ol>
</section>
<!-- Main content -->
<script type="text/javascript">
   $(document).ready(function(){
   $("#Provincia").change(function () {


           $("#Provincia option:selected").each(function () {
         
           //console.log( $('#Provincia').val());
           //pado el numero de pronvicia, es decir el id
            miprovincia=$('#Provincia').val();
            $.post("<?=base_url()?>index.php/c_administrador/mostrarLocalidad", { miprovincia: miprovincia}, function(data){
            $("#Localidad").html(data);
            });            
        });
   });

});
</script>
  

<section class="content">
<div class="modal" id="Registro">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                 <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h3 class="modal-title" style="color:white" >Registro Escribano</h3>
                                 </div>
                                 <div class="modal-body">
                                         <?php if( $exito ==TRUE) { ?>
                                          <div><img src="<?=base_url().'images/exito.png'?>" width='40px' height="40px" > <h3> El escribano se registro exitosamente, solicitud pendiente de revisión.</h3></div>
                                           <?php } else{ ?>
                                           <div> <img src="<?=base_url().'images/error.png'?>" width='40px' height="40px" > <label><h3>El escribano no se pudo registrar, compruebe que los campos de registración sean correctos.</h3></label></div>

                                           <?php } ?>

                                     </div>

                                 <div class="modal-footer">
                                  <a href="" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                                   <?php if($exito==TRUE){

                                     ?>
                                    <a href="<?=base_url().'index.php/c_administrador/verOperadores'?>" class="btn btn-primary" >Aceptar</a>
                                    <?php } ?>
                                 </div>
                              </div>
                            </div>
                  </div>


      <div class="row">
      <h3  align="center">Crear Operador</h3>

        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box box-primary" >
          <div class="box-body" style="background-color: lightblue;">
                    <div class="form-group">    
                      <?=form_open(base_url().'index.php/c_administrador/nuevoOperador')?>
                         <div class="row">
                         
                            <div class="col-md-3">
                               <label>Nombre y Apellido:</label><br>
                              <input type='text' name="nomyap" id="nomyap"  placeholder="Nombre y Apellido"   <?php echo "value='$nomyap'" ?> style="text-transform:uppercase;" onkeypress="return validar(event)" onkeyup="javascript:this.value=this.value.toUpperCase();">
                             
                            </div>

                            <div class="col-md-3">
                               <label>Usuario :</label><br>
                               <input type="text"   name="usuario" id="usuario" placeholder="Usuario" <?php echo "value='$usuario'" ?> maxlength="100"  >
                            </div>
                             <div class="col-md-3">
                               <label>Contraseña :</label><br>
                              <input type="password"   name="contraseña" id="contraseña" placeholder="Contraseña">
                            </div>
                              <div class="col-md-3">
                               <label> Repetir Contraseña :</label><br>
                              <input type="password"   name="repeContraseña" id="repeContraseña" placeholder="Repetir Contraseña">
                            </div>
                         

                          <div class="col-md-3">
                             <label>DNI :</label><br>
                              <input type="number"  name="dni" id="dni" placeholder="DNI" <?php echo "value='$dni'" ?> maxlength="8" onkeypress="return NumbersOnly(event);">
                          </div>


                         
 
                          <div class="col-md-3">
                              <label>Email :</label><br>
                             <input type="text"   name="email" id="email" placeholder="email" <?php echo "value='$correo'" ?>>
                          </div>



                          <div class="col-md-3">
                            <label>Telefono :</label><br>
                           
                             <input type="number" id="number" maxlength="15"   placeholder="+54" name="telefono" <?php echo "value='$telefono'" ?> onkeypress="return NumbersOnly(event);">  
                                              
                          </div>
                        
                          <div class="col-md-3">
                            <?php 
                            $provincias = $this->db->get("provincia")->result();
                                  $id_prov=0;
                                    ?>
                                 <label>Provincia</label><br>
                                      <select name="provincia" id="Provincia">
                                            <option value="">Selecciona una Provincia</option>
                                            <?php  foreach ($provincias as $p){ ?>
                                               <option value=
                                                <?php
                                               
                                                echo "' $p->idProvincia' > $p->nombre"; }?></option>
                                          

                                        </select>

                                     </div>
                   

                                      
                                       
                                       
                                  </div>
                                 

                         <div class="row">
                          <div class="col-md-3">
                                           
                                          
                                           <label>Localidad</label> <br>
                                              <select name="localidad" id="Localidad">
                                                   <option value="">Selecciona una Localidad </option>
                                              </select>
                           </div>

                          <div class="col-md-3">
                              <label>Dirección :</label><br>
                              <input type="text"  name="direccion" id="direccion" placeholder="Dirección">
                          </div>
                        <br>
                                   
                                 <br><br>
                               <div align="center"> <button type="submit" class="btn btn-primary" data-toggle="modal">Guardar Cambios</button></div>


                                 <div align="center" style="color:red;" ><p><?=form_error('nomyap')?></p></div> 
                                 <div align="center" style="color:red;" >  <p><?=form_error('dni')?></p></div>
                                 <div align="center" style="color:red;" ><p><?=form_error('correo')?></p></div>
                                 <div align="center" style="color:red;" > <p><?=form_error('telefono')?></p></div>
                                 <div align="center" style="color:red;" ><p><?=form_error('provincia')?></p></div>
                                 <div align="center" style="color:red;" ><p><?=form_error('localidad')?></p></div>
                                 <div align="center" style="color:red;" ><p><?=form_error('usuario')?></p></div>
                                 <div align="center" style="color:red;" > <p><?=form_error('contraseña')?></p></div>
                                  <div align="center" style="color:red;" > <p><?=form_error('repeContraseña')?></p>

                                            <?=form_close()?>


                               
                    
                  
                       </div>
                  </div>      

          </div>
        </div>
      </div>
</section>
</div>

                   
<script type="text/javascript">
  
    $(document).ready(function()
   {
      <?php if ($hizo_post) {  ?>
      $("#Registro").modal("show");
    <?php } ?>
   });
</script> 

