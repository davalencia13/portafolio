<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['protocol'] = 'smtp';  // Usamos SMTP para enviar correos
$config['smtp_host'] = 'mail.portafoliositiosweb.com';  // Servidor SMTP de salida
$config['smtp_port'] = 587;  // Puerto 587 para TLS
$config['smtp_user'] = 'admin@portafoliositiosweb.com';  // Tu correo de salida
$config['smtp_pass'] = '5-]P~M_3aA)x##N6';  // La contraseña de tu correo de salida
$config['mailtype'] = 'html';  // El correo será en formato HTML
$config['charset'] = 'utf-8';  // Usamos UTF-8 para la codificación de caracteres
$config['wordwrap'] = TRUE;  // Permite el ajuste automático de texto en los correos
$config['smtp_crypto'] = 'tls';  // Usar TLS para el puerto 587
$config['smtp_timeout'] = 60;  // Aumentado el tiempo de espera
$config['newline'] = "\r\n";  // Configuración de nueva línea
$config['crlf'] = "\r\n";  // Configuración de retorno de carro
