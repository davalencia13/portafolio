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
                redirect('dashboard'); // Redirige al dashboard
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
                redirect('dashboard'); // Redirige al dashboard
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

    public function perfil(){
        // Verificar si el usuario está logueado
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }

        // Obtener datos del usuario actual
        $user_id = $this->session->userdata('id');
        $user_data = $this->Model_User->get_user_by_id($user_id);

        if ($this->input->post()) {
            // Procesar actualización del perfil
            $this->form_validation->set_rules('name', 'Nombre', 'required|min_length[2]|max_length[100]');
            $this->form_validation->set_rules('phone', 'Teléfono', 'max_length[65]');
            $this->form_validation->set_rules('age', 'Edad', 'numeric|greater_than[0]|less_than[120]');
            $this->form_validation->set_rules('email', 'Email', 'valid_email|max_length[100]');
            $this->form_validation->set_rules('user', 'Usuario', 'required|min_length[3]|max_length[100]');

            if ($this->form_validation->run() == FALSE) {
                // Validación falló
                $this->session->set_flashdata('errors', validation_errors());
            } else {
                // Preparar datos para actualizar
                $update_data = array(
                    'name' => $this->input->post('name'),
                    'phone' => $this->input->post('phone'),
                    'age' => $this->input->post('age'),
                    'email' => $this->input->post('email'),
                    'user' => $this->input->post('user')
                );

                // Si se proporcionó una nueva contraseña
                if ($this->input->post('new_password') && !empty($this->input->post('new_password'))) {
                    $this->form_validation->set_rules('new_password', 'Nueva Contraseña', 'min_length[6]|max_length[20]');
                    $this->form_validation->set_rules('confirm_password', 'Confirmar Contraseña', 'matches[new_password]');
                    
                    if ($this->form_validation->run() == TRUE) {
                        $update_data['password'] = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT);
                    }
                }

                // Procesar subida de imagen si se proporcionó
                if (!empty($_FILES['user_image']['name'])) {
                    $config['upload_path'] = './uploads/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = 2048; // 2MB
                    $config['file_name'] = 'user_' . $user_id . '_' . time();

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('user_image')) {
                        $upload_data = $this->upload->data();
                        $update_data['image'] = $upload_data['file_name'];
                        
                        // Eliminar imagen anterior si existe
                        if ($user_data->image && file_exists('./uploads/' . $user_data->image)) {
                            unlink('./uploads/' . $user_data->image);
                        }
                    } else {
                        $this->session->set_flashdata('errors', 'Error al subir la imagen: ' . $this->upload->display_errors());
                    }
                }

                // Procesar subida de PDF si se proporcionó
                if (!empty($_FILES['user_pdf']['name'])) {
                    $config['upload_path'] = './uploads/';
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = 5120; // 5MB
                    $config['file_name'] = 'pdf_' . $user_id . '_' . time();

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('user_pdf')) {
                        $upload_data = $this->upload->data();
                        $update_data['pdf_file'] = $upload_data['file_name'];
                        
                        // Eliminar PDF anterior si existe
                        if ($user_data->pdf_file && file_exists('./uploads/' . $user_data->pdf_file)) {
                            unlink('./uploads/' . $user_data->pdf_file);
                        }
                    } else {
                        $this->session->set_flashdata('errors', 'Error al subir el PDF: ' . $this->upload->display_errors());
                    }
                }

                // Actualizar usuario
                if ($this->Model_User->update_user($user_id, $update_data)) {
                    $this->session->set_flashdata('success', 'Perfil actualizado correctamente');
                    
                    // Actualizar datos de sesión si cambió el nombre de usuario
                    if ($this->input->post('user') != $this->session->userdata('user')) {
                        $this->session->set_userdata('user', $this->input->post('user'));
                    }
                    
                    redirect('perfil');
                } else {
                    $this->session->set_flashdata('errors', 'Error al actualizar el perfil');
                }
            }
        }

        // Cargar vista con datos del usuario
        $data['user'] = $user_data;
        $this->load->view('view_perfil', $data);
    }
    
    public function recuperar_contrasena(){
        $this->load->view('view_recuperar_password'); // Redirige a la página de ingresar datos para recuperar contraseña
    }

}
