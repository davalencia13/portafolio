<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<body>
    <div class="container py-5">

        <br><br><br><br>
        <!--style> Using stiles
            .alert {
                font-family: Arial, sans-serif;
                font-size: 16px;
                margin: 20px;
                padding: 10px;
                border-radius: 4px;
            }
            
            .error {
                color:#f64823; /* Color rojo para errores */
                background: #f1c3ba; /* Fondo claro para errores */
            }

            .correcto {
                color:#3f8121; /* Color verde validaciones exitosas */
                background: #b3f893; /* Fondo claro para exitoso */
            }
            
        </style-->     

        <style>
            .form-container-custom {
                max-width: 50%;
                margin: 0 auto;
                padding: 2rem;
                background-color: #f8f9fa;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                border-radius: 12px;
            }
            
            @media(max-width: 768px) {
                .form-container-custom {
                    max-width: 100%;
                }
            }
        </style>
        

        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6"></div>
        </div>

        <div class="container d-flex align-items-center min-vh-100 py-5">
            <div class="form-container-custom">
                <h2 class="text-center mb-4">Iniciar Sesion</h2>     
                
                <?php  if($this->session->flashdata('errors')): ?>
                    <div class="alert alert-danger"> 
                        <?= $this->session->flashdata('errors'); // Muestra error si no pasa las validaciones ?>
                    </div> 
                <?php endif; ?>

                <?php  if($this->session->flashdata('correcto')): ?>
                    <div class="alert alert success">
                        <?= $this->session->flashdata('correcto'); // Muestra mensaje exitoso si paso todas las validaciones ?>
                    </div> 
                <?php endif; ?>

                <!-- Para verificar si la sesión esta abierta -->
                <?= $this->session->userdata('id'); ?>
                <?= $this->session->userdata('user'); ?>    
                <?= $this->session->userdata('logged_in'); ?>


                <form action="<?= base_url('iniciar'); ?>" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario:</label>
                                <input class="form-control" type="text" id="usuario" name="usuario" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Contraseña:</label>
                                <input class="form-control" type="text" id="contrasena" name="password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Ingresar</button>
                    </div>
                </form>
                
                <div class="text-center mt-3">
                    <a href="<?= base_url('recuperar_password'); ?>" class="text-decoration-none">¿Olvidó contraseña?</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>