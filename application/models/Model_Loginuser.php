<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_Loginuser extends CI_Model {

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

    public function insert_user($user_data){
        if(empty($user_data)){
            return false; // Si no hay datos, retorna false
        }
        $this->db->insert('rol_users', $user_data); // Inserta los datos en la tabla 'rol_users'

        //Get id user
        /*$id_user = $this->db->insert('rol_users', $user_data);
        if($id_user){
            return $this->db->insert_id(); // Retorna el ID del usuario insertado
        }else{
            return false; // Si no se pudo obtener el ID, retorna false
        }*/
    }
}