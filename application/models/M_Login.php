<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Login extends CI_Model {

	function _construct()
	{
		parent::__construct();//constructor es la primera función que va buscar la clase
	}

    public function get_user(){
        //$sql = "select * from rol_users"; // Consulta SQL para obtener todos los registros de la tabla 'users'
        //$query = $this->db->($sql); // Ejecuta la consulta SQL
        $query = $this->db->get('rol_users'); // Obtiene todos los registros de la tabla 'rol_users'
        return $query->result(); // Devuelve los resultados como un array
    }
}
