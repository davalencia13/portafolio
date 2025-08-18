<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificar Código de Autenticación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-container-custom p-4 bg-light rounded shadow-sm">
                    <h2 class="text-center mb-4">Verificar Código de Autenticación</h2>
                    <?php if($this->session->flashdata('errors')): ?>
                        <div class="alert alert-danger">
                            <?= $this->session->flashdata('errors'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if($this->session->flashdata('debug_msgs')): ?>
                        <div class="alert alert-info">
                            <?= $this->session->flashdata('debug_msgs'); ?>
                        </div>
                    <?php endif; ?>
                    <form action="<?= base_url('validar_codigo'); ?>" method="post">
                        <div class="mb-3">
                            <label for="codigo" class="form-label">Código recibido en su correo</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" required autofocus>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Verificar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

