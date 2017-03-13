<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_administrador extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
    }



	public function index()
	{
		if($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'Administrador')
		{
			redirect(base_url().'index.php/c_login_administrador');
		}
		$data["notificaciones_mp"]=$this->notificaciones_mp();
		$data["notificaciones_ep"]=$this->notificaciones_ep();
		$data['titulo'] = 'Bienvenido Administrador';

		$this->load->view('templates/cabecera_administrador',$data);
		$this->load->view('templates/admin_menu',$data);
		$this->load->view('home/admin',$data);
		$this->load->view('templates/pie',$data);
	}
	public function crearOperador($exito=FALSE, $hizo_post=FALSE){
		if($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'Administrador')
		{
			redirect(base_url().'index.php/c_login_administrador');
		}
		$data["notificaciones_mp"]=$this->notificaciones_mp();
		$data["notificaciones_ep"]=$this->notificaciones_ep();
		$data['titulo'] = 'Bienvenido Administrador';


		//busco todas las provincias
		$data['exito']= $exito; 
		$data['hizo_post']=$hizo_post;
	    $data['provincias'] = $this->db->get("provincia")->result();
		 // en caso de que venga de una registracion que no se pudo hacer por algun campo
		if($this->input->post() && !$exito){
			//seteo los demas input segun lo que ingreso anteriormente
			$data['nomyap'] = $this->input->post('nomyap');
			$data['dni'] = $this->input->post('dni');
			$data['correo'] = $this->input->post('correo');
			$data['telefono'] =(integer)$this->input->post('telefono');
			$data['usuario'] = $this->input->post('usuario');
			$data['direccion'] = $this->input->post('direccion');

		

		}else{
			$data['nomyap']='';
			$data['dni']='';
			$data{'correo'}='';
			$data{'telefono'}='';
			$data{'direccion'}='';
			$data{'usuario'}='';
			$data{'contraseña'}='';
			$data{'repeContraseña'}='';


		};
		

		$this->load->view('templates/cabecera_administrador',$data);
		$this->load->view('templates/admin_menu',$data);
		$this->load->view('administrador/crearOperador',$data);
		$this->load->view('templates/pie',$data);

	}
	public function nuevoOperador(){
			$hizo_post=TRUE;	

				 $this->load->helper(array('form', 'url'));

			    $this->form_validation->set_rules('nomyap', 'nomyap', 'required',array('required' => 'Debes ingresar un Nombre y Apellido ') );


			    $this->form_validation->set_rules('dni', 'dni', 'required|is_unique[usuariosys.dni]',array('required' => 'Debes ingresar DNI ','is_unique'=>'Ya existe un escribano con el DNI ingresado') );


			    $this->form_validation->set_rules('email', 'email', 'required|is_unique[usuariosys.email]',array('required' => 'Debes ingresar un correo ','is_unique'=>'Ya existe un escribano con el Correo ingresado') );

			    $this->form_validation->set_rules('telefono', 'telefono', 'required',array('required' => 'Debes ingresar numero de teleéfono ') );

			    $this->form_validation->set_rules('provincia', 'provincia', 'required',array('required' => 'Debes seleccionar una Provincia ') );

			    $this->form_validation->set_rules('localidad', 'localidad', 'required',array('required' => 'Debes seleccionar una Localidad ') );

			    $this->form_validation->set_rules('direccion', 'direccion', 'required',array('required' => 'Debes ingresar una dirección ') );
			   

				 $this->form_validation->set_rules('usuario', 'usuario',  'required|is_unique[usuariosys.usuario]|min_length[6]',array('required' => 'Debes ingresar un nombre de Usuario ','is_unique'=>'Ya existe un Operador con el nombre de usuario ingresado','min_length'=> 'El nombre de usuario debe ser de al menos 6 digitos') );

			    $this->form_validation->set_rules('contraseña', 'contraseña', 'required|min_length[6]',array('required' => 'Debes ingresar una contraseña ','min_length'=> 'La contraseña debe ser de al menos 6 dígitos ') );

			    $this->form_validation->set_rules('repeContraseña', 'repeContraseña', 'required|matches[contraseña]',array('required' => 'Debes volver a ingresar la contraseña ','matches'=> 'Las dos contraseñas no coinciden ') );

		
		
			if($this->form_validation->run() == FALSE)
			{	
				
				$this->crearOperador(FALSE,TRUE);
			}else{
			$datetime_variable = new DateTime();
			$datetime_formatted = date_format($datetime_variable, 'Y-m-d H:i:s');
			$datos_usuarios= array (
			'nomyap' => $this->input->post("nomyap"),
			'usuario' => $this->input->post("usuario"),	
			'contraseña' => $this->input->post("contraseña"),	
			'dni' => $this->input->post("dni"),	
			'telefono' => $this->input->post("telefono"),
			'direccion' => $this->input->post("direccion"),	
			'idLocalidad' => $this->input->post('localidad'),	
			'fechaReg'=>$datetime_formatted,
			'tipoUsuario'=>"O",
			'email' => $this->input->post('email'));	

			$this->db->insert("usuariosys", $datos_usuarios);

			

			$data['provincias'] = $this->db->get("provincia")->result();
		 
		    $this->crearOperador(TRUE,TRUE);

	}
}

	public function verOperadores()
	{
		if($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'Administrador')
		{
			redirect(base_url().'index.php/c_login_administrador');
		}
		$data['titulo'] = 'Bienvenido Administrador';
		
		$data["notificaciones_mp"]=$this->notificaciones_mp();
		$data["notificaciones_ep"]=$this->notificaciones_ep();
		$data["operadores"] = $this->M_administrador->getOperadores();

		$this->load->view('templates/cabecera_administrador',$data);
		$this->load->view('templates/admin_menu',$data);
		$this->load->view('administrador/verOperadores',$data);
		$this->load->view('templates/pie',$data);
	}
	
	public function verEscribanos()
	{
		if($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'Administrador')
		{
			redirect(base_url().'index.php/c_login_administrador');
		}
		$data['titulo'] = 'Bienvenido Administrador';
		
		$data["notificaciones_mp"]=$this->notificaciones_mp();
		$data["notificaciones_ep"]=$this->notificaciones_ep();
		$data["escribanos"] = $this->M_administrador->getEscribanos();

		$this->load->view('templates/cabecera_administrador',$data);
		$this->load->view('templates/admin_menu',$data);
		$this->load->view('administrador/verEscribanos',$data);
		$this->load->view('templates/pie',$data);
	}


	public function editarOperador($idUsuario="")
	{
		if($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'Administrador')
		{
			redirect(base_url().'index.php/c_login_administrador');
		}
	
		$data["notificaciones_mp"]=$this->notificaciones_mp();
		$data["notificaciones_ep"]=$this->notificaciones_ep();
		$data['titulo'] = 'Bienvenido Administrador';
		$data["operador"] = $this->db->get_where('usuariosys', array('idUsuario'=>$idUsuario))->row();
		//var_dump($data["operador"]);
		$this->load->view('templates/cabecera_administrador',$data);
		$this->load->view('templates/admin_menu',$data);
		$this->load->view('administrador/editarOperador',$data);
		$this->load->view('templates/pie',$data);
	}

	public function actualizarOperador()
	{
		if($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'Administrador')
		{
			redirect(base_url().'index.php/c_login_administrador');
		}
		$data["notificaciones_mp"]=$this->notificaciones_mp();
		$data["notificaciones_ep"]=$this->notificaciones_ep();
		$idUsuario = $this->input->post("idUsuario");
		$operadorAct= array(
			//Nombre del campo en la bd -----> valor del campo name en la vista
			'nomyap' => $this->input->post("nomyap"),
			'usuario' => $this->input->post("usuario"),	
			'contraseña' => $this->input->post("contraseña"),	
			'dni' => $this->input->post("dni"),	
			'telefono' => $this->input->post("telefono"),
			'direccion' => $this->input->post("direccion"),	
			'idLocalidad' => $this->input->post('localidad'),	
			'email' => $this->input->post('email'),	

			);

		
		$ctrl=$this->M_administrador->actualizarOperador($operadorAct,$idUsuario);

		$data['titulo'] = 'Bienvenido Administrador';
		

		//Si se inserto correcto la vble $ctrl devuelve true y redirije a la pagina con los mismos datos
		//deberia ir a la pagina de veroperador 
		if ($ctrl) {
			redirect('c_administrador/verOperadores');

		} else {
			//Si no se guardo correctamente entonces queda en la pagina para realizar los cambios
			redirect('','refresh');
		}
	}

	public function eliminar_op(){
      	$idUsuario=$_POST["idUsuario"];
		$this->db->where('idUsuario', $idUsuario);
		$this->db->delete('usuariosys'); 

      }




	public function editarEscribano($idEscribano="")
	{
		if($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'Administrador')
		{
			redirect(base_url().'index.php/c_login_administrador');
		}
	
		$data["notificaciones_mp"]=$this->notificaciones_mp();
		$data["notificaciones_ep"]=$this->notificaciones_ep();
		$data['titulo'] = 'Bienvenido Administrador';
		$esc=$this->db->get_where('usuarioescribano', array('idEscribano'=>$idEscribano))->row();
		$data["escribano"] =$esc;
		//var_dump($data["operador"]);
		$this->load->view('templates/cabecera_administrador',$data);
		$this->load->view('templates/admin_menu',$data);
		$this->load->view('administrador/editarEscribano',$data);
		$this->load->view('templates/pie',$data);
	}

	public function actualizarEscribano()
	{
		if($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'Administrador')
		{
			redirect(base_url().'index.php/c_login_administrador');
		}
		$data["notificaciones_mp"]=$this->notificaciones_mp();
		$data["notificaciones_ep"]=$this->notificaciones_ep();
		$idEscribano = $this->input->post("idEscribano");
		$escribanoAct= array(
			//Nombre del campo en la bd -----> valor del campo name en la vista
			'nomyap' => $this->input->post("nomyap"),
			'usuario' => $this->input->post("usuario"),	
			'contraseña' => sha1($this->input->post("contraseña")),	
			'dni' => $this->input->post("dni"),	
			'telefono' => $this->input->post("telefono"),
			'direccion' => $this->input->post("direccion"),	
			'idLocalidad' => $this->input->post('localidad'),	
			'matricula' => $this->input->post('matricula'),
			'estadoAprobacion' => $this->input->post('estadoAprobacion'),	
			'email' => $this->input->post('email'),	




			);

		
		$ctrl=$this->M_administrador->actualizarEscribano($escribanoAct,$idEscribano);

		$data['titulo'] = 'Bienvenido Administrador';
		

		//Si se inserto correcto la vble $ctrl devuelve true y redirije a la pagina con los mismos datos
		//deberia ir a la pagina de veroperador 
		if ($ctrl) {
			redirect('c_administrador/verEscribanos');

		} else {
			//Si no se guardo correctamente entonces queda en la pagina para realizar los cambios
			redirect('','refresh');
		}
	}

	public function eliminar_es(){
      	$idUsuario=$_POST["idEscribano"];
		$this->db->where('idEscribano', $idEscribano);
		$this->db->delete('usuarioescribano'); 

      }

//para el menu minutas

	public function reg_pen()
	{
		if($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'Administrador')
		{
			redirect(base_url().'index.php/c_login_administrador');
		}
		$data["notificaciones_mp"]=$this->notificaciones_mp();
		$data["notificaciones_ep"]=$this->notificaciones_ep();
		$esc_pen=$this->db->get_where('usuarioescribano', array('estadoAprobacion'=>'P'))->result();
		$data['esc_pen']=$esc_pen;
		
		$data['titulo'] = 'Bienvenido Operador';
		$this->load->view('templates/cabecera_administrador',$data);
		$this->load->view('templates/operador_menu',$data);
		$this->load->view('operador/registraciones_pendientes',$data);
		$this->load->view('templates/pie',$data);
	}

	public function detalles_esc(){
			$idEscribano=$_POST["idEscribano"];
			$esc=$this->db->get_where('usuarioescribano', array('idEscribano'=>$idEscribano))->row();
			 echo " <tr>
                          <td>$esc->nomyap</td>  
                        	<td>  $esc->usuario</td>
                            <td> $esc->dni</td>
                            <td>  $esc->matricula</td>
                            <td> $esc->direccion</td>
                            <td> $esc->email</td>
                            <td> $esc->telefono</td>
                            <td>$esc->estadoAprobacion</td>
                       </tr>
                         "; 
                         }
      public function aceptar_esc(){
      	$idEscribano=$_POST["idEscribano"];
      		$data = array(
               'estadoAprobacion' => "A",
              
            );

		$this->db->where('idEscribano', $idEscribano);
		$this->db->update('usuarioescribano', $data); 

      }
      public function rechazar_esc(){
      		$idEscribano=$_POST["idEscribano"];
      		$motivoRechazo=$_POST["motivoRechazo"];
      		$data = array(
               'estadoAprobacion' => "R",
              	'motivoRechazo' =>"$motivoRechazo"
            );

		$this->db->where('idEscribano', $idEscribano);
		$this->db->update('usuarioescribano', $data); 

      }
      
      public function eliminar_esc(){
      	$idEscribano=$_POST["idEscribano"];
      		

		$this->db->where('idEscribano', $idEscribano);
		$this->db->delete('usuarioescribano'); 

      }
		

	public function reg_apro()
	{
		if($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'Administrador')
		{
			redirect(base_url().'index.php/c_login_administrador');
		}
		$data["notificaciones_mp"]=$this->notificaciones_mp();
		$data["notificaciones_ep"]=$this->notificaciones_ep();
		$esc_apro=$this->db->get_where('usuarioescribano', array('estadoAprobacion'=>'A'))->result();
		$data['esc_apro']=$esc_apro;
		$data['titulo'] = 'Bienvenido Operador';
		$this->load->view('templates/cabecera_administrador',$data);
		$this->load->view('templates/operador_menu',$data);
		$this->load->view('operador/registraciones_aprobadas',$data);
		$this->load->view('templates/pie',$data);
	}

	public function reg_rech()
	{
		if($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'Administrador')
		{
			redirect(base_url().'index.php/c_login_operador');
		}
		$data["notificaciones_mp"]=$this->notificaciones_mp();
		$data["notificaciones_ep"]=$this->notificaciones_ep();
		$esc_rech=$this->db->get_where('usuarioescribano', array('estadoAprobacion'=>'R'))->result();
		$data['esc_rech']=$esc_rech;
		$data['titulo'] = 'Bienvenido Operador';
		$this->load->view('templates/cabecera_administrador',$data);
		$this->load->view('templates/operador_menu',$data);
		$this->load->view('operador/registraciones_rechazadas',$data);
		$this->load->view('templates/pie',$data);
	}

	public function ver_minutasPendientes()
	{
		if($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'Administrador')
		{
			redirect(base_url().'index.php/c_login_administrador');
		}
		$data["notificaciones_mp"]=$this->notificaciones_mp();
		$data["notificaciones_ep"]=$this->notificaciones_ep();
		$this->db->select('*');
		$this->db->from('estadominuta');
		$this->db->join('minuta', 'minuta.idMinuta = estadominuta.idMinuta');
		$this->db->join('usuarioescribano', 'usuarioescribano.idEscribano = minuta.idEscribano');
		$this->db->order_by('estadominuta.fechaEstado', 'ASC');
		$this->db->where('estadominuta.estadoMinuta', 'P');

		$data['minutas']= $this->db->get()->result();

		$data['titulo'] = 'Bienvenido Operador';
		$this->load->view('templates/cabecera_administrador',$data);
		$this->load->view('templates/admin_menu',$data);
		$this->load->view('administrador/minutas_pendientes',$data);
		$this->load->view('templates/pie',$data);
	}

	public function detalles_minuta(){


		$idMinuta=$_POST['idMinuta'];
		$minuta = $this->M_escribano->getUnaMinuta($idMinuta);
		$idEscribano = $minuta[0]->idEscribano;
		$unEscribano = $this->M_escribano->getUnEscribano($idEscribano);
		$idMinuta = $minuta[0]->idMinuta;
		$parcelas =$this->M_escribano->getParcelas($idMinuta);
		echo "
			  <article>
         <!-- Titulo -->
         <h2 class='page-header' align='center'><i><b>Minuta de Inscripción de Titulo</b></i>
         </h2>
         <p align='justify'>
            Departamento  <strong>".$unEscribano[0]->nombreDpto.".</strong>
            - Provincia de <strong>".$unEscribano[0]->nombreProv.".</strong><br>
            FUNCIONARIO AUTORIZANTE: Esc: <strong>  ".$unEscribano[0]->nomyap.".</strong><br>";
          foreach ($parcelas as $value) { 
          	echo" <br>
            BIEN: <strong> ".$value->descripcion."</strong>.<br>
            <br>";
           	$propietarios = $this->M_escribano->getPropietarios($value->idParcela); 
            foreach ( $propietarios as $key) { 
               $nroProp = 0;
               if ($key->tipoPropietario == 'A'): echo "ADQUIRIENTE: <br>";
               endif ;
               if  ($key->tipoPropietario == 'T'): echo  "TRANSMITENTE: <br>"; endif; 
           		echo" NRO UF/UC: <strong>";
           		 if ($key->nroUfUc == NULL) echo '-------';  else echo $key->nroUfUc ; 
           		 echo"-" ;
           		 echo $key->tipoUfUc;
           		 echo "</strong>Fecha de Escritura: <strong>";
           		 if ($key->fechaEscritura == NULL) echo '-------';  else echo $key->fechaEscritura ;
           		 echo".</strong>Nombre y Apellido: <strong>";
           		 if ($key->titular == NULL) echo '-------';  else echo $key->titular ;
           		 echo".</strong>Cuit - Cuil: <strong>";
           		  if ($key->cuitCuil == NULL) echo '-------';  else echo $key->cuitCuil ;
           		  echo"</strong>Direccion: <strong>";
           		   if ($key->direccion == NULL) echo '-------';  else echo $key->direccion; 
           		   echo".</strong> Plano Aprobado: <strong>";
           		   if ($key->planoAprobado == NULL) echo '-------';  else echo $key->planoAprobado ;
           		   echo".</strong>Fecha de Plano Aprobado: <strong>";
           		    if ($key->fechaPlanoAprobado == NULL) echo '-------';  else echo $key->fechaPlanoAprobado ;
           		    echo".</strong> Poligonos: <strong>";
           		    if ($key->poligonos == NULL) echo '-------';  else echo $key->poligonos ;
           		    echo".</strong> Porcentaje de Uf/Uc: <strong>";
           		     if ($key->porcentajeUfUc == NULL) echo '-------';  else echo $key->porcentajeUfUc ;
           		     echo".</strong><br>Asentimiento Conyugal: <strong>";
           		      if ($key->conyuge == NULL) echo '-------';  else echo $key->conyuge ;
           		      echo".</strong><br>";
          										} 
              } 
        echo" </p></article>";
     	}

		  public function rechazar_min	(){
		      		$idEstadoMinuta=$_POST["idEstadoMinuta"];
		      		$motivoRechazo=$_POST["motivoRechazo"];
		      		$datetime_variable = new DateTime();
					$datetime_formatted = date_format($datetime_variable, 'Y-m-d H:i:s');
		      		$data = array(
		               'estadoMinuta' => "R",
		              	'motivoRechazo' =>"$motivoRechazo",
		              	'idUsuario'=>$this->session->userdata('idUsuario'),
		              	'fechaEstado'=> $datetime_formatted 
		            );

				$this->db->where('idEstadoMinuta', $idEstadoMinuta);
				$this->db->update('estadominuta', $data); 

		      }

		   public function aceptar_min(){
				$idEstadoMinuta=$_POST["idEstadoMinuta"];
				$datetime_variable = new DateTime();
				$datetime_formatted = date_format($datetime_variable, 'Y-m-d H:i:s');
		      		$data = array(
		               'estadoMinuta' => "A",
			           	'idUsuario'=>$this->session->userdata('idUsuario'),
			           	'fechaEstado'=> $datetime_formatted 
		              
		            );

				$this->db->where('idEstadoMinuta', $idEstadoMinuta);
				$this->db->update('estadominuta', $data); 

      }

      public function ver_minutas()
	{
		if($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'Administrador')
		{
			redirect(base_url().'index.php/c_login_administrador');
		}
		$data["notificaciones_mp"]=$this->notificaciones_mp();
		$data["notificaciones_ep"]=$this->notificaciones_ep();
		$this->db->select('*');
		$this->db->from('minuta');
		
		
		$minutas= $this->db->get()->result();
		
		//obtengo el ultimo estado de cada minuta
		$min=null;
		foreach ($minutas as $mi) {
			  			$this->db->from('estadominuta');
                         $this->db->where('idMinuta', $mi->idMinuta); 
                         $this->db->order_by('idEstadoMinuta', 'DESC');
                         $estadoMinuta= $this->db->get()->row();
          // solo necesito guardar el estado y el idEstadoMinuta
          //entonces junto creo una nueva variable
           $datosMinutas=array("idMinuta" => "$mi->idMinuta","idEscribano" => "$mi->idEscribano", "fechaIngresoSys" => "$mi->fechaIngresoSys","fechaEdicion" => "$mi->fechaEdicion","idEstadoMinuta" => "$estadoMinuta->idEstadoMinuta","estadoMinuta" =>"$estadoMinuta->estadoMinuta");
           $arreglo=array($datosMinutas);
         	if ($min==null){
         		$min=$arreglo;
                
         	}
         	else{
         		$min=array_merge($min,$arreglo);    
		};
         	}
         		  
		$data['minutas']=$min;


		$data['titulo'] = 'Bienvenido Operador';
		$this->load->view('templates/cabecera_administrador',$data);
		$this->load->view('templates/admin_menu',$data);
		$this->load->view('administrador/ver_minutas',$data);
		$this->load->view('templates/pie',$data);
	}

	public function ver_estados(){
		$idMinuta=$_POST['idMinuta'];
		$estadoMinuta=$this->db->get_where('estadominuta', array('idMinuta'=>$idMinuta))->result();
		foreach ($estadoMinuta as $e) {
			$idUsuario=$e->idUsuario;
			if ($idUsuario!=null){
			$usuario=$this->db->get_where('usuariosys', array('idUsuario'=>$idUsuario))->row();
				 echo " <tr>
				 		    <td>  $e->fechaEstado</td>
  							<td>  $e->estadoMinuta</td>
                            <td> $e->motivoRechazo</td>
 							<td> $usuario->nomyap</td>
                       </tr>
                         "; 
	
					}
			else {
				 echo " <tr>
                         <td>  $e->fechaEstado</td>
  							<td>  $e->estadoMinuta</td>
                            <td> $e->motivoRechazo</td>
 							<td> </td>
                       </tr>	";
			}

					 }

			

	}
//para obtener las localidades
		public function departamento()
	{
		$id_prov=$_POST["miprovincia"];
		
		//$departamentos=$this->db->get("departamento")->result();
	   	
	   	$departamentos=$this->db->get_where('departamento', array('idProvincia'=>$id_prov))->result();
	
		
		foreach ($departamentos as $d ) {
				
				echo"<option value='$d->idDepartamento'>$d->nombre</option>";
			
		}
	}

		public function mostrarLocalidad()
	{
		$id_prov=$_POST["miprovincia"];
		
		$this->db->select('localidad.idLocalidad, localidad.nombre');
		$this->db->from('localidad');
		$this->db->join('departamento', 'localidad.idDepartamento = departamento.idDepartamento AND departamento.idProvincia ='.$id_prov);
		

		$localidades=$this->db->get()->result();
	   	
		//en este caso quiero que en el value aparezca el id que esta en la tabla , porque este valor me va a servir para insertar en la tabla usuarioescribano
		foreach ($localidades as $l ) {
				
				echo"<option value='$l->idLocalidad'>$l->nombre</option>";
			
		}
	}

	
	public function notificaciones_mp(){
						$this->db->from('estadominuta');
                         $this->db->where('estadoMinuta', "P"); 
                        return( $this->db->get()->result()); 

	}
		public function notificaciones_ep(){
						$this->db->from('usuarioescribano');
                         $this->db->where('estadoAprobacion', "P"); 
                        return( $this->db->get()->result()); 

	}

		public function notificaciones_si(){
						$this->db->from('estadominuta');
                         $this->db->where('estadoMinuta', "P"); 
                        return( $this->db->get()->result()); 

	}
	//en caso de que haga click en las notificaciones guarda los id y el estado para que aparezca la tabla filtrada por
	public function buscar_esc_p_x_dni(){
			if ($_POST["dniEscribano"]==null) {
				$dniEscribano="";
			}else
			{
				$dniEscribano=$_POST["dniEscribano"];
			};
		   $noti_esc=array("dniEscribano"=>$dniEscribano,"estado"=>"P");
		  	  $this->session->set_flashdata('noti_esc',$noti_esc); 
		    redirect(base_url().'index.php/c_administrador/verEscribanos');
	}
	public function buscar_min_p_x_id(){
			if ($_POST["idMinuta"]==null) {
				$idMinuta="";
			}else
			{
				$idMinuta=$_POST["idMinuta"];
			};
			$noti_min=array("idMinuta"=>$idMinuta,"estado"=>"P");
		   $this->session->set_flashdata('noti_min',$noti_min); 
		    redirect(base_url().'index.php/c_administrador/ver_minutas');
	}

	public function obtenerProvincia_x_idLoc(){
		$idLocalidad=$_POST["idLocalidad"];
		$this->db->select('*');
		$this->db->from('departamento');
		$this->db->join('localidad', 'localidad.idDepartamento = departamento.idDepartamento');
		

		echo $this->db->get()->row()->idProvincia;
	}
	

}
