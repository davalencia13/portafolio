    </main>
    
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h5>
                    <p class="mb-0">Sistema de gestión y administración</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">
                        <i class="fas fa-clock me-1"></i>
                        <?= date('d/m/Y H:i:s') ?>
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-user me-1"></i>
                        Usuario: <?= $this->session->userdata('user') ?>
                    </p>
                </div>
            </div>
            <hr class="my-3">
            <div class="row">
                <div class="col-12 text-center">
                    <small>&copy; <?= date('Y') ?> Dashboard. Todos los derechos reservados.</small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html> 