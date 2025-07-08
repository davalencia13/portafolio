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
            $mensaje = "
                <!DOCTYPE html>
                <html lang='es'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Recuperación de Contraseña</title>
                </head>
                <body style='margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;'>
                    <table width='100%' cellpadding='0' cellspacing='0' style='background-color: #f4f4f4;'>
                        <tr>
                            <td align='center' style='padding: 40px 0;'>
                                <table width='600' cellpadding='0' cellspacing='0' style='background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>
                                    <!-- Header -->
                                    <tr>
                                        <td style='background-color: #007bff; padding: 30px; text-align: center; border-radius: 8px 8px 0 0;'>
                                            <h1 style='color: #ffffff; margin: 0; font-size: 24px;'>Recuperación de Contraseña</h1>
                                        </td>
                                    </tr>
                                    
                                    <!-- Content -->
                                    <tr>
                                        <td style='padding: 40px 30px;'>
                                            <p style='color: #333333; font-size: 16px; margin-bottom: 20px;'>Hola <strong>".$usuario->name."</strong>,</p>
                                            
                                            <p style='color: #555555; font-size: 14px; line-height: 1.6; margin-bottom: 15px;'>
                                                Has solicitado recuperar tu contraseña. Aquí tienes tus datos de acceso:
                                            </p>
                                            
                                            <div style='background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 20px; margin: 25px 0;'>
                                                <p style='margin: 10px 0; color: #333333;'><strong>Usuario:</strong> <span style='color: #007bff;'>".$usuario->user."</span></p>
                                                <p style='margin: 10px 0; color: #333333;'><strong>Contraseña:</strong> <span style='color: #007bff;'>".$usuario->password."</span></p>
                                            </div>
                                            
                                            <p style='color: #555555; font-size: 14px; line-height: 1.6; margin-bottom: 25px;'>
                                                Por seguridad, te recomendamos cambiar tu contraseña después de iniciar sesión.
                                            </p>
                                            
                                            <!-- Login Button -->
                                            <table width='100%' cellpadding='0' cellspacing='0'>
                                                <tr>
                                                    <td align='center'>
                                                        <a href='".base_url('login')."' style='display: inline-block; background-color: #007bff; color: #ffffff; text-decoration: none; padding: 12px 30px; border-radius: 6px; font-weight: bold; font-size: 16px;'>Iniciar Sesión</a>
                                                    </td>
                                                </tr>
                                            </table>
                                            
                                            <p style='color: #666666; font-size: 12px; margin-top: 30px; text-align: center;'>
                                                Si no solicitaste esta recuperación, puedes ignorar este correo.
                                            </p>
                                        </td>
                                    </tr>
                                    
                                    <!-- Footer -->
                                    <tr>
                                        <td style='background-color: #f8f9fa; padding: 20px; text-align: center; border-radius: 0 0 8px 8px;'>
                                            <p style='color: #666666; font-size: 12px; margin: 0;'>
                                                Saludos,<br>
                                                <strong>Equipo de Portafoliositiosweb</strong>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </body>
                </html>
            ";
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