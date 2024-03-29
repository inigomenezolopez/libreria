<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<title>Iniciar sesión</title>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-xxl-6 col-lg-8 col-md-10 col-sm-12">
        <div class="card text-bg-danger mb-3">
            <div class="card-header">
                <img src="./images/login.png" class="img-fluid col-1 float-end" alt="Imagen del formulario login">
                <h1>Iniciar sesión</h1>
            </div>
            <div class="card-body">
                <!-- Mensaje de éxito si el registro fue exitoso -->
                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                <form method="post" action="<?= base_url("login"); ?>">
                    <div class="mb-3">
                        <label for="email" class="form-label">Dirección de correo electrónico</label>
                        <input type="email" class="form-control" name="email" id="email" aria-describedby="Input de email" required>
                        <!-- Error si validación falla-->
                        <?php if (isset($validation)) : ?>
                            <small class="text-white"><?= $validation->getError('email'); ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <!-- Enlace para restablecer la contraseña -->
                        <div class="mt-2">
                            <a href="<?= base_url(route_to('admin.forgot.form')) ?>" class="btn btn-link text-white" style="padding-left: 0;">Restablecer contraseña</a>
                        </div>
                        <!-- Error si validación falla-->
                        <?php if (isset($validation)) : ?>
                            <small class="text-white"><?= $validation->getError('password'); ?></small>
                        <?php endif; ?>
                    </div>
                     <!-- Error si validación falla-->
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="mt-3 mb-3">
                            <span class="text-white" style="font-size: larger; font-weight: bold;"><?= session()->getFlashdata('error'); ?></span>
                        </div>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-dark">Enviar</button>
                    <div class="d-flex justify-content-between mt-3">
                        <p class="text-white">¿No tienes cuenta? <a href="<?= base_url(route_to('register'))?>" class="btn btn-link text-white">Registrarse</a></p>
                        <p><a href="<?= base_url(route_to('admin.login.form')) ?>" class="btn btn-link text-white">Acceso como administrador ➜</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<?= $this->endSection() ?>
