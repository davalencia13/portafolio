<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Verificar si el usuario está logueado
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    /**
     * Método principal del dashboard
     * Muestra la vista del dashboard con estadísticas y datos
     */
    public function index()
    {
        // Datos para el dashboard
        $data['title'] = 'Dashboard - Panel de Control';
        
        // Aquí puedes cargar datos desde el modelo si es necesario
        // $data['usuarios'] = $this->Model_User->get_all_users();
        // $data['productos'] = $this->Model_Producto->get_all_products();
        
        // Cargar la vista del dashboard
        $this->load->view('dashboard', $data);
    }

    /**
     * Método para obtener estadísticas del dashboard via AJAX
     */
    public function get_stats()
    {
        // Verificar si es una petición AJAX
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // Aquí puedes obtener datos reales desde la base de datos
        $stats = array(
            'usuarios_activos' => 150,
            'total_productos' => 2350,
            'ventas_mensual' => 45000,
            'pedidos_pendientes' => 18
        );

        // Devolver respuesta en JSON
        header('Content-Type: application/json');
        echo json_encode($stats);
    }

    /**
     * Método para obtener actividad reciente
     */
    public function get_recent_activity()
    {
        // Verificar si es una petición AJAX
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        // Aquí puedes obtener datos reales desde la base de datos
        $activity = array(
            array(
                'type' => 'user_register',
                'message' => 'Nuevo usuario registrado',
                'time' => 'Hace 5 min',
                'icon' => 'fas fa-user-plus',
                'color' => 'text-success'
            ),
            array(
                'type' => 'product_added',
                'message' => 'Producto agregado al inventario',
                'time' => 'Hace 15 min',
                'icon' => 'fas fa-box',
                'color' => 'text-primary'
            ),
            array(
                'type' => 'sale_completed',
                'message' => 'Nueva venta realizada',
                'time' => 'Hace 30 min',
                'icon' => 'fas fa-shopping-cart',
                'color' => 'text-info'
            ),
            array(
                'type' => 'low_stock',
                'message' => 'Stock bajo en producto',
                'time' => 'Hace 1 hora',
                'icon' => 'fas fa-exclamation-triangle',
                'color' => 'text-warning'
            )
        );

        // Devolver respuesta en JSON
        header('Content-Type: application/json');
        echo json_encode($activity);
    }
} 