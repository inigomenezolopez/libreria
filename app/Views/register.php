<?php echo $this->include('/layout/navbar.php'); ?>
<title>Registrarse</title>



<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-xxl-6 col-lg-8 col-md-10 col-sm-12">
        <div class="card text-bg-danger mb-3">
            <div class="card-header">
                <img src="../public/images/signup.png" class="img-fluid col-1 float-end" alt="Imagen del formulario registro">
                <h1>Registro</h1>
            </div>
            <div class="card-body">
                <form method="post" action="<?= base_url("register"); ?>">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="name" class="form-control" name="name" id="name" aria-describedby="Input de nombre" required>
                        <?php if (isset($validation)) : ?>
                            <small class="text-white"><?= $validation->getError('name'); ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label"> Dirección de correo electrónico </label>
                        <input type="email" class="form-control" name="email" id="email" aria-describedby="Input de email" required>
                        <?php if (isset($validation)) : ?>
                            <small class="text-white"><?= $validation->getError('email'); ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Crea tu contraseña</label>
                        <input type="password" min="5" maxlength="20" class="form-control" id="password" name="password" required>
                        <?php if (isset($validation)) : ?>
                            <small class="text-white"><?= $validation->getError('password'); ?></small>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-dark">Enviar</button>
                    <p class="mt-3 text-white">¿Ya tienes una cuenta? <a href="/libreria/public/login" class="btn btn-link text-white">Iniciar sesión</a></p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo $this->include('/layout/footer.php'); ?>