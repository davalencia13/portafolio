<?php //Página de perfil de usuario
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->load->view('header'); ?>

<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4">
            <i class="fas fa-user-edit me-2"></i>Mi Perfil
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>Editar Información Personal
                </h5>
            </div>
            <div class="card-body">
                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?= $this->session->flashdata('success'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if($this->session->flashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?= $this->session->flashdata('errors'); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('perfil'); ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-1"></i>Nombre Completo *
                                </label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?= set_value('name', $user->name); ?>" required>
                                <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user" class="form-label">
                                    <i class="fas fa-at me-1"></i>Nombre de Usuario *
                                </label>
                                <input type="text" class="form-control" id="user" name="user" 
                                       value="<?= set_value('user', $user->user); ?>" required>
                                <?= form_error('user', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-1"></i>Correo Electrónico
                                </label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= set_value('email', $user->email); ?>">
                                <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone me-1"></i>Teléfono
                                </label>
                                <input type="text" class="form-control" id="phone" name="phone" 
                                       value="<?= set_value('phone', $user->phone); ?>">
                                <?= form_error('phone', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="age" class="form-label">
                                    <i class="fas fa-birthday-cake me-1"></i>Edad
                                </label>
                                <input type="number" class="form-control" id="age" name="age" 
                                       value="<?= set_value('age', $user->age); ?>" min="1" max="120">
                                <?= form_error('age', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_image" class="form-label">
                                    <i class="fas fa-camera me-1"></i>Foto de Perfil
                                </label>
                                <input type="file" class="form-control" id="user_image" name="user_image" 
                                       accept="image/*">
                                <small class="text-muted">Formatos: JPG, PNG, GIF. Máximo 2MB</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_pdf" class="form-label">
                                    <i class="fas fa-file-pdf me-1"></i>Documento PDF
                                </label>
                                <input type="file" class="form-control" id="user_pdf" name="user_pdf" 
                                       accept=".pdf">
                                <small class="text-muted">Solo archivos PDF. Máximo 5MB</small>
                                <?php if(isset($user->pdf_file) && $user->pdf_file && file_exists('./uploads/' . $user->pdf_file)): ?>
                                    <div class="mt-2">
                                        <a href="<?= base_url('uploads/' . $user->pdf_file); ?>" 
                                           class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="fas fa-download me-1"></i>Ver PDF Actual
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <!-- Campo vacío para mantener el diseño -->
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="new_password" class="form-label">
                                    <i class="fas fa-lock me-1"></i>Contraseña actual
                                </label>
                                <input type="password" class="form-control" id="old_password" name="old_password" 
                                       minlength="3" maxlength="20">
                                <?= form_error('old_password', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="new_password" class="form-label">
                                    <i class="fas fa-lock me-1"></i>Nueva Contraseña
                                </label>
                                <input type="password" class="form-control" id="new_password" name="new_password" 
                                       minlength="3" maxlength="20">
                                <small class="text-muted">Deja en blanco para mantener la actual</small>
                                <?= form_error('new_password', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">
                                    <i class="fas fa-lock me-1"></i>Confirmar Nueva Contraseña
                                </label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                       minlength="3" maxlength="20">
                                <?= form_error('confirm_password', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= base_url('dashboard'); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Volver al Dashboard
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user-circle me-2"></i>Mi Perfil
                </h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <?php if(isset($user->image) && $user->image && file_exists('./uploads/' . $user->image)): ?>
                        <img src="<?= base_url('uploads/' . $user->image); ?>" 
                             class="rounded-circle" width="120" height="120" 
                             style="object-fit: cover;" alt="Foto de perfil">
                    <?php else: ?>
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" 
                             style="width: 120px; height: 120px;">
                            <i class="fas fa-user fa-3x text-white"></i>
                        </div>
                    <?php endif; ?>
                </div>
                
                <h5 class="mb-1"><?= $user->name ?: 'Sin nombre'; ?></h5>
                <p class="text-muted mb-3">@<?= $user->user; ?></p>
                
                <div class="text-start">
                    <?php if($user->email): ?>
                        <p class="mb-2">
                            <i class="fas fa-envelope me-2 text-muted"></i>
                            <?= $user->email; ?>
                        </p>
                    <?php endif; ?>
                    
                    <?php if($user->phone): ?>
                        <p class="mb-2">
                            <i class="fas fa-phone me-2 text-muted"></i>
                            <?= $user->phone; ?>
                        </p>
                    <?php endif; ?>
                    
                    <?php if($user->age): ?>
                        <p class="mb-2">
                            <i class="fas fa-birthday-cake me-2 text-muted"></i>
                            <?= $user->age; ?> años
                        </p>
                    <?php endif; ?>
                    
                    <?php if(isset($user->pdf_file) && $user->pdf_file && file_exists('./uploads/' . $user->pdf_file)): ?>
                        <p class="mb-2">
                            <i class="fas fa-file-pdf me-2 text-danger"></i>
                            <a href="<?= base_url('uploads/' . $user->pdf_file); ?>" 
                               class="text-decoration-none" target="_blank">
                                Documento PDF
                            </a>
                        </p>
                    <?php endif; ?>
                    
                    <p class="mb-0">
                        <i class="fas fa-calendar me-2 text-muted"></i>
                        Miembro desde: <?= date('d/m/Y', strtotime($user->date)); ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="card shadow mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Información
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Los campos marcados con * son obligatorios
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-image text-info me-2"></i>
                        Puedes subir una foto de perfil (JPG, PNG, GIF - 2MB)
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-file-pdf text-danger me-2"></i>
                        Documentos PDF permitidos (máximo 5MB)
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-lock text-warning me-2"></i>
                        La contraseña debe tener al menos 6 caracteres
                    </li>
                    <li>
                        <i class="fas fa-shield-alt text-primary me-2"></i>
                        Tus datos están seguros y encriptados
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 15px;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px 15px 0 0 !important;
    border: none;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 25px;
    padding: 10px 25px;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    transform: translateY(-1px);
}

.alert {
    border-radius: 10px;
    border: none;
}
</style>

<?php $this->load->view('footer'); ?>
