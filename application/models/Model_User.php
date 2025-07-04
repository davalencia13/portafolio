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

    // Función para obtener usuario por ID
    public function get_user_by_id($user_id){
        $this->db->where('id_user', $user_id);
        $query = $this->db->get('rol_users');
        
        if($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    // Función para actualizar usuario
    public function update_user($user_id, $data){
        $this->db->where('id_user', $user_id);
        return $this->db->update('rol_users', $data);
    }

    // Función para verificar si el nombre de usuario ya existe (excluyendo el usuario actual)
    public function check_username_exists($username, $exclude_user_id = null){
        $this->db->where('user', $username);
        if($exclude_user_id) {
            $this->db->where('id_user !=', $exclude_user_id);
        }
        $query = $this->db->get('rol_users');
        return $query->num_rows() > 0;
    }

    // Función para verificar si el email ya existe (excluyendo el usuario actual)
    public function check_email_exists($email, $exclude_user_id = null){
        $this->db->where('email', $email);
        if($exclude_user_id) {
            $this->db->where('id_user !=', $exclude_user_id);
        }
        $query = $this->db->get('rol_users');
        return $query->num_rows() > 0;
    }

    // Función para obtener usuario por correo electrónico
    public function get_user_by_email($email){
        $this->db->where('email', $email);
        $query = $this->db->get('rol_users');
        return $query->row();
    }
}