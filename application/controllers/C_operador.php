<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * 
 */
class C_operador extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
	
	}
	
	public function index()
	{
		if($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'operador')
		{
			redirect(base_url().'index.php/c_login_operador');
		}
		$data['titulo'] = 'Bienvenido Escribano';
		$this->load->view('templates/cabecera_operador',$data);
		$this->load->view('templates/operador_menu',$data);
		$this->load->view('home/operador',$data);
		$this->load->view('templates/pie',$data);
	}

	public function reg_pen()
	{
		if($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'operador')
		{
			redirect(base_url().'index.php/c_login_operador');
		}

		$esc_pen=$this->db->get_where('usuarioescribano', array('estadoAprobacion'=>'P'))->result();
		$data['esc_pen']=$esc_pen;
		
		$data['titulo'] = 'Bienvenido Operador';
		$this->load->view('templates/cabecera_operador',$data);
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
		if($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'operador')
		{
			redirect(base_url().'index.php/c_login_operador');
		}

		$esc_apro=$this->db->get_where('usuarioescribano', array('estadoAprobacion'=>'A'))->result();
		$data['esc_apro']=$esc_apro;
		$data['titulo'] = 'Bienvenido Operador';
		$this->load->view('templates/cabecera_operador',$data);
		$this->load->view('templates/operador_menu',$data);
		$this->load->view('operador/registraciones_aprobadas',$data);
		$this->load->view('templates/pie',$data);
	}
	public function reg_rech()
	{
		if($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'operador')
		{
			redirect(base_url().'index.php/c_login_operador');
		}

		$esc_rech=$this->db->get_where('usuarioescribano', array('estadoAprobacion'=>'R'))->result();
		$data['esc_rech']=$esc_rech;
		$data['titulo'] = 'Bienvenido Operador';
		$this->load->view('templates/cabecera_operador',$data);
		$this->load->view('templates/operador_menu',$data);
		$this->load->view('operador/registraciones_rechazadas',$data);
		$this->load->view('templates/pie',$data);
	}

}