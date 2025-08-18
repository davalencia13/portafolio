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

    public function iniciar() {
        $this->form_validation->set_rules('usuario', 'Usuario', 'required');
        $this->form_validation->set_rules('password', 'Contraseña', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect('login');
            return;
        }

        $usuario = $this->input->post('usuario');
        $contrasena = $this->input->post('password');
        $user = $this->Model_User->user_validation_encript($usuario);

        if ($user && password_verify($contrasena, $user->password)) {
            // Generar código de autenticación
            $codigo = rand(100000, 999999);
            $expiracion = date('Y-m-d H:i:s', strtotime('+2 hours'));
            $this->Model_User->set_auth_code($user->id_user, $codigo, $expiracion);
            // Actualizar el objeto usuario con el código
            $user->auth_code = $codigo;
            $user->auth_code_expiry = $expiracion;
            // Enviar el código por correo
            $this->load->library('email');
            $this->load->helper('url');
            $this->load->model('Model_User');
            $this->load->library('session');
            $this->load->helper('form');
            $this->load->helper('security');
            $this->load->library('form_validation');
            $this->load->library('user_agent');
            $this->load->library('encryption');
            $this->load->library('C_correo');
            $this->C_correo->enviar_codigo_autenticacion($user);
            // Guardar temporalmente el id del usuario para la verificación
            $this->session->set_userdata('pending_2fa_user', $user->id_user);
            redirect('ingresarcodigo');
        } else {
            $this->session->set_flashdata('errors', 'Usuario o contraseña incorrectos');
            redirect('login');
        }
    }

    // Vista para ingresar el código de autenticación
    public function verificar_codigo() {
        $this->load->view('view_verificar_codigo');
    }

    // Validar el código de autenticación
    public function validar_codigo() {
        $user_id = $this->session->userdata('pending_2fa_user');
        $codigo = $this->input->post('codigo');
        $user = $this->Model_User->get_user_by_id($user_id);

        // Mensajes de depuración
        $debug_msgs = [];
        $debug_msgs[] = '2FA: user_id de sesión: ' . print_r($user_id, true);
        $debug_msgs[] = '2FA: Código recibido del formulario: ' . print_r($codigo, true);
        $debug_msgs[] = '2FA: Usuario obtenido de la BD: ' . print_r($user, true);
        if ($user) {
            $debug_msgs[] = '2FA: Email del usuario: ' . $user->email;
            $debug_msgs[] = '2FA: Código almacenado en BD: ' . $user->auth_code;
            $debug_msgs[] = '2FA: Expiración almacenada en BD: ' . $user->auth_code_expiry;
        }
        $debug_str = implode('<br>', $debug_msgs);
        $this->session->set_flashdata('debug_msgs', $debug_str);

        if ($user && $user->auth_code == $codigo && strtotime($user->auth_code_expiry) > time()) {
            // Código correcto y no expirado, crear sesión
            $user_data = array(
                'id' => $user->id_user,
                'user' => $user->user,
                'logged_in' => true,
            );
            $this->session->set_userdata($user_data);
            // Limpiar el código de autenticación
            $this->Model_User->set_auth_code($user->id_user, null, null);
            $this->session->unset_userdata('pending_2fa_user');
            // Mantener los mensajes de depuración para el dashboard
            $this->session->set_flashdata('debug_msgs', $debug_str);
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('errors', 'Código incorrecto o expirado.');
            redirect('verificar_codigo');
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

            // Si se proporcionó una nueva contraseña, agregar reglas de validación
            if ($this->input->post('new_password') && !empty($this->input->post('new_password'))) {
                $this->form_validation->set_rules('old_password', 'Contraseña actual', 'required');
                $this->form_validation->set_rules('new_password', 'Nueva Contraseña', 'min_length[3]|max_length[20]');
                $this->form_validation->set_rules('confirm_password', 'Confirmar Contraseña', 'required|matches[new_password]');
                
                // Mensajes personalizados para las reglas de validaciones de contraseña
                $this->form_validation->set_message('matches', 'La nueva contraseña y confirmar contraseña no coinciden');
                $this->form_validation->set_message('required', 'El campo %s es obligatorio');
                $this->form_validation->set_message('min_length', 'El campo %s debe tener al menos %s caracteres');
                $this->form_validation->set_message('max_length', 'El campo %s no puede tener más de %s caracteres');
            }

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

                // Si se proporcionó una nueva contraseña, validar contraseña actual
                if ($this->input->post('new_password') && !empty($this->input->post('new_password'))) {
                    $user = $this->Model_User->get_user_by_id($user_id); // Obtener el usuario actual
                    if (password_verify($this->input->post('old_password'), $user->password)) {
                        $update_data['password'] = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT);
                    } else {
                        $this->session->set_flashdata('errors', 'Contraseña actual incorrecta');
                        redirect('perfil');
                        return;
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
        $this->load->view('view_recuperar_contrasena'); // Redirige a la página de ingresar datos para recuperar contraseña
    }

    public function recuperar() {
        $correo = $this->input->post('usuario');
        if (!$correo) {
            $this->session->set_flashdata('errors', 'Debe ingresar un correo electrónico.');
            redirect('recuperar_password');
            return;
        }
        // Buscar usuario por email
        $this->load->model('Model_User');
        $usuario = $this->Model_User->get_user_by_email($correo);
        if ($usuario) {
            // Llamar al controlador de correo para enviar los datos
            $this->load->library('C_correo');
            $this->C_correo->enviar_correo();
        } else {
            $this->session->set_flashdata('errors', 'No existe un usuario registrado con ese correo electrónico.');
            redirect('recuperar_password');
        }
    }
}
