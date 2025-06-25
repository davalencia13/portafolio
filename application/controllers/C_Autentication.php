<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Autentication extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_User');
        //$this->load->model('model_login');
        //$this->load->model('model_play');
        //$this->load->library('cart');
    }

    //Funcion sin enviar password encriptado
    public function login(){
        $this->form_validation->set_rules('user', 'Usuario', 'required'); // Reglas de validación para el campo 'user'
        $this->form_validation->set_rules('contrasena', 'Contrasena', 'required'); // Reglas de validación para el campo 'user'

        if($this->form_validation->run() == FALSE) // Verifica si la validación falla
            {	
                //echo 'error user'; // Muestra mensaje de error
                $this->session->set_flashdata('errors', 'Usuario no existe'); // Establece un mensaje flash para mostrar al usuario
                //redirect('login');
                //return; // Termina la ejecución de la función
            }
            
            $usuario = $this->input->post('usuario'); // Obtiene el valor del campo 'user' del formulario - Usar los mismos del atributo
            $contrasena = $this->input->post('password'); // Obtiene el valor del campo 'contrasena' del formulario

            //Llamar al model Model_User la función para validar el usuario
            $user = $this->Model_User->user_validation($usuario, $contrasena); // Llama al modelo para obtener el usuario por nombre de usuario

            if($user) { // Verifica si se encontró un usuario
                $user_data =array(//crear la sesión del usuario
                    'id' => $user->id_user, // Establece el ID del usuario
                    'user' => $user->user, // Establece el nombre de usuario
                    'logged_in' => true, // Marca al usuario como autenticado
                );
                $this->session->set_userdata($user_data); // Establece el usuario en la sesión
                redirect('welcome'); // Redirige a la página de bienvenida
            } else {
                $this->session->set_flashdata('errors', 'Usuario o contraseña incorrectos'); // Establece un mensaje flash de error
                redirect('login'); // Redirige a la página de inicio de sesión
            }
    }

    //Funcion enviando password encriptado
    public function login_encript(){
        $this->form_validation->set_rules('user', 'Usuario', 'required'); // Reglas de validación para el campo 'user'
        $this->form_validation->set_rules('contrasena', 'Contrasena', 'required'); // Reglas de validación para el campo 'user'

        if($this->form_validation->run() == FALSE) // Verifica si la validación falla
            {	
                //echo 'error user'; // Muestra mensaje de error
                $this->session->set_flashdata('errors', 'Usuario no existe'); // Establece un mensaje flash para mostrar al usuario
                //redirect('login');
                //return; // Termina la ejecución de la función
            }
            
            $usuario = $this->input->post('usuario'); // Obtiene el valor del campo 'user' del formulario - Usar los mismos del atributo
            $contrasena = $this->input->post('password'); // Obtiene el valor del campo 'contrasena' del formulario

            //Para consultarlo encriptado
            $encript = password_hash($contrasena, PASSWORD_BCRYPT); // Encripta la contraseña usando BCRYPT
            //Verificar el usuario
            $user = $this->Model_User->user_validation_encript($usuario); // Llama al modelo para obtener el usuario por nombre de usuario

            if($user && password_verify($contrasena,$user->password)) {
                //echo $contrasena;
                //echo $user->password;
                //echo password_verify($contrasena,$user->password);
                
                // Verifica si se encontró un usuario
                $user_data =array(//crear la sesión del usuario
                    'id' => $user->id_user, // Establece el ID del usuario
                    'user' => $user->user, // Establece el nombre de usuario
                    'logged_in' => true, // Marca al usuario como autenticado
                );
                $this->session->set_userdata($user_data); // Establece el usuario en la sesión
                redirect('welcome'); // Redirige a la página de bienvenida
            } else {
                $this->session->set_flashdata('errors', 'Usuario o contraseña incorrectos'); // Establece un mensaje flash de error
                redirect('login'); // Redirige a la página de inicio de sesión
            }
    }

    public function cerrar_sesion(){
        $this->session->sess_destroy(); // Destruye la sesión actual
        $this->session->set_flashdata('correct', 'Sesion cerrada correctamente'); // Establece un mensaje flash de error
        redirect('login'); // Redirige a la página de inicio de sesión
    }

}
