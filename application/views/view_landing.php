<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<body>
    <div class="container py-5">
        <h2>Iniciar Sesión</h2>
        <form action="<?= site_url('login/validar'); ?>" method="post">
            <label for="usuario">Usuario:</label><br>
            <input type="text" id="usuario" name="usuario" required><br><br>

            <label for="contrasena">Contraseña:</label><br>
            <input type="password" id="contrasena" name="contrasena" required><br><br>

            <input type="submit" value="Ingresar">
        </form>

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
                <h2 class="text-center mb-4">Registro de Usuario</h2>

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

                <form action="<?= base_url('enviadatos'); ?>" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input class="form-control" type="text" id="nombre" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="edad" class="form-label">Edad:</label>
                                <input class="form-control" type="text" id="edad" name="age" required>   
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono:</label>
                                <input class="form-control" type="text" id="telefono" name="phone" required> 
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario:</label>
                                <input class="form-control" type="text" id="usuario" name="user" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contrasena" class="form-label">Contraseña:</label>
                                <input class="form-control" type="text" id="contrasena" name="password" required>
                            </div>
                        </div> 
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
        <br><br>
        <h2>Registro de Usuarios</h2>
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Contraseña</th>
                    <th>Teléfono</th>
                    <th>Edad</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $user): //$usuarios debe ser como se declaro $data en el controlador?>
                    <tr>
                        <td><?php echo $user->id_user; ?></td> 
                        <td><?php echo $user->name; ?></td>
                        <td><?php echo $user->user; ?></td>
                        <td><?php echo $user->password; ?></td>
                        <td><?php echo $user->phone; ?></td>
                        <td><?php echo $user->age; ?></td>
                        <td><?php echo $user->date; ?></td>
                    </tr>
                <?php endforeach; ?>
            
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>