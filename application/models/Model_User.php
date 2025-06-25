<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_User extends CI_Model {

	function _construct()
	{
		parent::__construct();//constructor es la primera función que va buscar la clase
	}

    public function user_validation($usuario, $contrasena){
        $this->db->where('user',$usuario); // Establece la condición para filtrar por el campo 'user'
        $this->db->where('password', $contrasena); // Establece la condición para filtrar por el campo 'contrasena'
        $query = $this->db->get('rol_users'); // Obtiene todos los registros de la tabla 'rol_users'

        if($query->num_rows() > 0) { // Verifica si se encontraron resultados
            return $query->row(); // Devuelve el primer resultado como un objeto
        }
    }

    // Función para validar el usuario con contraseña encriptada
    public function user_validation_encript($usuario){
        $this->db->where('user',$usuario); // Establece la condición para filtrar por el campo 'user'
        $query = $this->db->get('rol_users'); // Obtiene todos los registros de la tabla 'rol_users'

        if($query->num_rows() > 0) { // Verifica si se encontraron resultados
            return $query->row(); // Devuelve el primer resultado como un objeto
        }
    }
}