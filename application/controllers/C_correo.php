<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_correo extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_User');    //Cargamos el modelo de usuario
        $this->load->library('email');
    }

    public function enviar_correo(){
        // Configuración adicional para evitar problemas de conexión
        $this->email->clear();
        
        $correo = $this->input->post('usuario'); 
        $usuario = $this->Model_User->get_user_by_email($correo);
        
        if($usuario){
            $mensaje = 'Hola '.$usuario->name.',<br><br>Tu usuario es: '.$usuario->user.'<br>Tu contraseña es: '.$usuario->password.'<br><br>Saludos,<br>Equipo de Portafoliositiosweb';
        }else{  
            $this->session->set_flashdata('errors', 'Usuario no encontrado con ese correo electrónico.');
            redirect('recuperar_password');
            return;
        }

        // Configurar el email
        $this->email->from('admin@portafoliositiosweb.com', 'Portafoliositiosweb');
        $this->email->to($correo); // Descomentado para enviar al correo correcto
        $this->email->subject('Recuperación de contraseña');
        $this->email->message($mensaje);

        // Intentar enviar el email con manejo de errores
        try {
            if($this->email->send()){
                $this->session->set_flashdata('correcto', 'Se han enviado sus datos de acceso a su correo electrónico.');
            }else{
                $this->session->set_flashdata('errors', 'Error al enviar el correo. Por favor, intente más tarde.');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('errors', 'Error de conexión al enviar el correo. Por favor, intente más tarde.');
        }
        
        redirect('recuperar_password');
    }
}