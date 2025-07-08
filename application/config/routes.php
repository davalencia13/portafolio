<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//$route['default_controller'] = 'producto'; //controlador producto
$route['default_controller'] = 'Login/showuser'; //controlador login
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'Login/showuser'; //controlador login fubnction showuser
$route['enviadatos'] = 'Login/send'; //controlador login function envia
$route['iniciar'] = 'C_Autentication/login_encript'; //controlador autenticación function login
$route['cerrar'] = 'C_Autentication/cerrar_sesion'; //controlador autenticación function login
$route['welcome'] = 'Producto/hola'; //controlador autenticación function login
$route['registrar'] = 'login/register'; //controlador autenticación function login
$route['login/validar'] = 'Login/validar'; //controlador login function validar

// Rutas para el Dashboard
$route['dashboard'] = 'Dashboard/index'; //controlador dashboard function index
$route['dashboard/stats'] = 'Dashboard/get_stats'; //controlador dashboard function get_stats
$route['dashboard/activity'] = 'Dashboard/get_recent_activity'; //controlador dashboard function get_recent_activity

// Rutas para el Perfil
$route['perfil'] = 'C_Autentication/perfil'; //controlador autenticación function perfil

//Ruta para recuperar correo
$route['recuperar'] = 'C_correo/enviar_correo'; //controlador login function validar

//Ruta para recuperar contraseña
$route['recuperar_password'] = 'C_Autentication/recuperar_contrasena'; //Function to recover password   
$route['change_password'] = 'C_Autentication/change_password'; //Function to change password