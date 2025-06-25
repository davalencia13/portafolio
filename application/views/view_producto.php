<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>BIENVENIDO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="text-center">
            <h1 class="display-4 fw-bold">¡BIENVENIDO!</h1>
            <p class="lead">Gracias por visitar la página para registrar usuarios</p>
            <div class="d-flex justify-content-center gap-2 mt-4">
                <a href="<?= base_url('registrar'); ?>" class="btn btn-primary btn-lg">Registrar</a>
                <?= form_open('cerrar', ['class' => 'm-0 p-0']); ?>
                    <button type="submit" class="btn btn-danger btn-lg">Cerrar Sesión</button>
                <?= form_close(); ?>
            </div>
        </div>

        <!-- Formulario para cerrar sesión -->
      

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>