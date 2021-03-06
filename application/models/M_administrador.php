<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
*/
class M_administrador extends CI_Model
{
	
	public function __construct() {
		parent::__construct();
	}

	public function getOperadores(){
		$this->db->where('tipoUsuario',"O");
		$operadores =$this->db->get("usuariosys")->result();
		return $operadores;
	}

	public function getEscribanos(){

		try {
			$query = $this->db->query("

				select case 
					when estadoAprobacion = 'P' then 0
					when estadoAprobacion = 'A' then 1
					when estadoAprobacion = 'R' then 2 else 3 end
				as id, 
				case 
					when estadoAprobacion = 'P' then 'Pendiente'
					when estadoAprobacion = 'A' then 'Aceptado'
					when estadoAprobacion = 'R' then 'Rechazado' else '' end
				as descEstado,
				u.*
				from usuarioescribano u
			

				order by id asc

				");
			return $query->result();
		} catch (Exception $e) {
			return false;
		}
	}

	public function getUnOperador($idUsuario)
	{
		try {
			$query = $this->db->query("
				SELECT *
				FROM usuariosys u
				where u.idUsuario = $idUsuario
				");
			return $query->result();
		} catch (Exception $e) {
			return false;
		}	
		}

	public function actualizarOperador($operador,$id)
	{
		try{
			$this->db->where('idUsuario',$id);
			return $this->db->UPDATE('usuariosys',$operador);

			} catch (Exception $e) {
			return false;
		}

		}


	public function actualizarEscribano($escribano,$id)
	{
		try{
			$this->db->where('idEscribano',$id);
			return $this->db->UPDATE('usuarioescribano',$escribano);

			} catch (Exception $e) {
			return false;
		}

		}

	public function getUnaMinuta($idMinuta)
	{
		try {
			$query = $this->db->query("
				SELECT idMinuta, idEscribano, idUsuario, fechaIngresoSys, fechaEdicion
				FROM minuta m
				where m.idMinuta = $idMinuta
				");
			return $query->result();
		} catch (Exception $e) {
			return false;
		}
	
	}
	public function getUnEscribano($idEscribano)
	{
		try {
			$query = $this->db->query("
				SELECT u.nomyap, u.usuario, u.fechaReg, u.email, u.dni, u.direccion, u.telefono, l.nombre  as nombreLocalidad, d.nombre as nombreDpto, p.nombre as nombreProv,
				case 
				when estadoAprobacion = 'P' then 'Pendiente'
				when estadoAprobacion = 'R' then 'Rechazado'
				when estadoAprobacion = 'A' then 'Aprobado' else '' end as descEstadoAp
				FROM usuarioescribano u inner join localidad  l
				on  l.idLocalidad = u.idLocalidad
				inner join departamento d
				on d.idDepartamento = l.idDepartamento
				inner join provincia p
				on p.idProvincia = d.idProvincia
				WHERE idEscribano = $idEscribano
				");
			return $query->result();
		} catch (Exception $e) {
			return false;
		}
	}
	public function getUnEscribano2($idEscribano)
	{
		try {
			$query = $this->db->query("
				SELECT u.nomyap, u.usuario, u.fechaReg, u.email, u.dni, u.direccion, u.telefono, l.nombre  as nombreLocalidad, d.nombre as nombreDpto, p.nombre as nombreProv,
				case 
				when estadoAprobacion = 'P' then 'Pendiente'
				when estadoAprobacion = 'R' then 'Rechazado'
				when estadoAprobacion = 'A' then 'Aprobado' else '' end as descEstadoAp,
				matricula
				FROM usuarioescribano u inner join localidad  l
				on  l.idLocalidad = u.idLocalidad
				inner join departamento d
				on d.idDepartamento = l.idDepartamento
				inner join provincia p
				on p.idProvincia = d.idProvincia
				WHERE idEscribano = $idEscribano
				");
			return $query->row();
		} catch (Exception $e) {
			return false;
		}
	}

	public function getUnAdmin($idAdmin)
	{
		try {
			$query = $this->db->query("
				SELECT idUsuario, nomyap, usuario, contraseña,
				concat(substring(fechaReg, 9, 2), '/' ,substring(fechaReg, 6, 2) , '/', substring(fechaReg, 1, 4)) as fechaReg, 
				dni, telefono, direccion, email, u.idLocalidad as idLocalidad, l.nombre as localidad, tipoUsuario, foto, baja 
				FROM usuariosys u inner join localidad l on l.idLocalidad = u.idLocalidad
				where idUsuario = $idAdmin
				");
			return $query->result();
		} catch (Exception $e) {
			return FALSE;
		}
	}

		public function actualizarAdministrador($operador,$id)
	{
		try{
			$this->db->where('idUsuario',$id);
			return $this->db->UPDATE('usuariosys',$operador);

			} catch (Exception $e) {
			return false;
		}

		}

		public function reportePedido()
		{
				try {$query=$this->db->query("
					SELECT p.idPedido, 
					    concat(substring(p.fechaPedido, 9, 2), '/' ,substring(p.fechaPedido, 6, 2) , '/', substring(p.fechaPedido, 1, 4)) as fechaPedido,
					    concat(substring(p.fechaRta, 9, 2), '/' ,substring(p.fechaRta, 6, 2) , '/', substring(p.fechaRta, 1, 4)) as fechaRta,
					    
					    substring(p.descripcion, 1, 46) as descripcion,
					    substring(p.rtaPedido, 1, 46) as rtaPedido,
					    p.estadoPedido,
					    case 
					     when p.estadoPedido = 'P' then 'Pendiente'
					     when p.estadoPedido = 'C' then 'Contestado'
					     else '' end as descEstadoPedido,

					    p.idEscribano, u.nomyap  
					 FROM pedidos p left join usuariosys u on p.idUsuario = u.idUsuario "


    );
    return $query->result();
					
				} catch (Exception $e) {
					return false;
				}
		}

	public function actualizarFoto($usuario, $idUsuario)
 	{
 		try{
			$this->db->where('idUsuario',$idUsuario);
			$this->db->UPDATE('usuariosys',$usuario);
			return TRUE;

			} catch (Exception $e) {
			return false;
		}
 	}


}


