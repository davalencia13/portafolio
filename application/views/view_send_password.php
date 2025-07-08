<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Recuperar contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<body>
    <div class="container py-5">

        <style>
            .form-container-custom {
                max-width: 50%;
                margin: 0 auto;
                padding: 2rem;
                background-color: #f8f9fa;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
            }
            
            @media(max-width: 768px) {
                .form-container-custom {
                    max-width: 100%;
                }
            }
        </style>

        <div class="container d-flex align-items-center min-vh-100 py-5">
            <div class="form-container-custom">
                <h2 class="text-center mb-4">Recuperar Contraseña</h2>
                
                <p class="text-center text-muted mb-4">
                    Ingrese su correo electrónico y le enviaremos sus datos de inicio de sesión.
                </p>
                
                <?php if($this->session->flashdata('errors')): ?>
                    <div class="alert alert-danger"> 
                        <?= $this->session->flashdata('errors'); ?>
                    </div> 
                <?php endif; ?>

                <?php if($this->session->flashdata('correcto')): ?>
                    <div class="alert alert-success">
                        <?= $this->session->flashdata('correcto'); ?>
                    </div> 
                <?php endif; ?>
                
                <form action="<?= base_url('recuperar'); ?>" method="post">
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico:</label>
                        <input class="form-control" type="email" id="correo" name="usuario" 
                               placeholder="ejemplo@correo.com" required>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
                
                <div class="text-center mt-4">
                    <a href="<?= base_url('login'); ?>" class="text-decoration-none">
                        ← Volver al inicio de sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>