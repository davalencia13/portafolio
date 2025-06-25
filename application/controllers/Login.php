<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_Login');
		$this->load->model('Model_Loginuser');
		//$this->load->model('model_login');
		//$this->load->model('model_play');
		//$this->load->library('cart');
	}

	public function showuser()
	{
		$data['usuarios'] = $this->M_Login->get_user(); // Arreglo usuarios llama al modelo para obtener los usuarios
		$this->load->view('view_login',$data); // Carga la vista y le pasa el arreglo de usuarios
	}

	public function register()
	{
		$data['usuarios'] = $this->M_Login->get_user(); // Arreglo usuarios llama al modelo para obtener los usuarios
		$this->load->view('view_register',$data); // Carga la vista y le pasa el arreglo de usuarios
	}

	public function showloginuser()
	{
		$data['usuarios'] = $this->M_Login->get_user(); // Arreglo usuarios llama al modelo para obtener los usuarios
		$this->load->view('view_login',$data); // Carga la vista y le pasa el arreglo de usuarios
	}

	public function send()
	{
		//Validaciones campos del formulario en el controlador
		$this->form_validation->set_rules('user', 'Usuario', 'required|min_length[4]|max_length[10]|alpha_numeric'); // Reglas de validación para el campo 'user'
		$this->form_validation->set_rules('name', 'nombre', 'required|min_length[6]|max_length[80]|alpha_numeric_spaces'); // Reglas de validación para el campo 'nombre'
		$this->form_validation->set_rules('password','contrasena','required|min_length[2]|max_length[20]'); // Reglas de validación para el campo 'password'
		$this->form_validation->set_rules('age', 'edad', 'required|numeric|greater_than[18]|less_than[80]'); // Reglas de validación para el campo 'age'
		
		if($this->form_validation->run() == FALSE) // Verifica si la validación falla
		{	
			//echo 'error user'; // Muestra mensaje de error
			$this->session->set_flashdata('errors', 'Error creando usuario'); // Establece un mensaje flash para mostrar al usuario
			redirect('login');
			//return; // Termina la ejecución de la función
		}

		//password_hash($this->input->post('password'), PASSWORD_ARGON2I); // Otra forma de Encripta la contraseña usando password_hash
		$contraencript = password_hash($this->input->post('password'), PASSWORD_BCRYPT); // Encripta la contraseña usando password_hash
		$name = $this->input->post('name'); // Envia nombre desde el formulario
		$user = $this->input->post('user'); // Envia usuario desde el formulario
		//$password = $this->input->post('password'); // Envia password desde el formulario
		$phone = $this->input->post('phone'); // Envia teléfono desde el formulario
		$age = $this->input->post('age'); // Envia edad desde el formulario
		//echo $user; // Muestra el usuario en la pantalla pero genera error con el redirect

		$data = array(
			'user' => $user, // Envia usuario desde el formulario
			'password' => $contraencript, // Envia contraseña encriptada
			'name' => $name, // Envia nombre desde el formulario	
			'phone' => $phone, // Envia teléfono desde el formulario
			'age' => $age, // Envia edad desde el formulario
			'date' => date('Y-m-d H:i:s'), // Función que envia fecha y hora actual
		);

		//Sin esperar el ID del usuario
		$this->Model_Loginuser->insert_user($data); // Llama al modelo para insertar el usuario en la base de datos
		$this->session->set_flashdata('correcto', 'Usuario creado exitosamente'); // Establece un mensaje flash para mostrar al usuario
		redirect('login'); // Redirige a la función showuser() del controlador login

		//Esperando el ID del usuario
		//$insert_id = $this->Model_Loginuser->insert_user($data);
		//echo $insert_id;


		/*// Verificar si la solicitud es POST
		if ($this->input->method() !== 'post') {
			echo "Error: La solicitud no es POST.";
			return;
		}
	
		// Obtener el valor enviado por POST
		$user = $this->input->post('user');
		if (!$user) {
			echo "Error: No se recibió el campo 'user'.";
			return;
		}
	
		// Mostrar el usuario en pantalla
		echo "Usuario recibido: " . $user;*/

		//$user = $_POST['user']; // Envia usuario desde el formulario
		
		//$this->load->helper('input');
		//$user = post ('user'); // Envia usuario desde el formulario
		

		/*echo '<style>
        .debug {background:#f5f5f5; padding:20px; margin:10px; border:1px solid #ddd;}
        .debug h3 {margin-top:0;}
    	</style>';

		echo '<div class="debug">';
		echo '<h3>Información del Servidor:</h3>';
		echo '<pre>'.print_r($_SERVER, true).'</pre>';
		echo '</div>';

		echo '<div class="debug">';
		echo '<h3>Datos POST Globales ($_POST):</h3>';
		echo '<pre>'.print_r($_POST, true).'</pre>';
		echo '</div>';

		echo '<div class="debug">';
		echo '<h3>Datos CodeIgniter ($this->input->post()):</h3>';
		echo '<pre>'.print_r($this->input->post(), true).'</pre>';
		echo '</div>';

		echo '<div class="debug">';
		echo '<h3>Headers de la Solicitud:</h3>';
		echo '<pre>'.print_r(getallheaders(), true).'</pre>';
		echo '</div>';

		die('Fin de la depuración');*/

	}
}
