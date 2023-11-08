<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php echo $this->include('/layout/navbar.php'); ?>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-xxl-6 col-lg-8 col-md-10 col-sm-12">
            <div class="card text-bg-danger mb-3">
                <div class="card-header">
                    <img src="./images/login.png" class="img-fluid col-1 float-end" alt="Imagen del formulario login">
                    <h1>Iniciar sesión</h1>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= base_url("login"); ?>">
                        <div class="mb-3">
                            <label for="email" class="form-label">Dirección de correo electrónico</label>
                            <input type="email" class="form-control" name="email" id="email" aria-describedby="Input de email" required>
                            <?php if(isset($validation)):?>
                                <small class="text-white"><?= $validation->getError('email');?></small>
                            <?php endif;?>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <?php if(isset($validation)):?>
                                <small class="text-white"><?= $validation->getError('password');?></small>
                            <?php endif;?>
                        </div>
                        <?php if(session()->getFlashdata('error')):?>
                            <div class="mt-3 mb-3">
                                <span class="text-white" style="font-size: larger; font-weight: bold;"><?= session()->getFlashdata('error');?></span>
                            </div>
                        <?php endif;?>
                        <button type="submit" class="btn btn-dark">Enviar</button>
                        <p class="mt-3 text-white">¿No tienes cuenta? <a href="/libreria/public/register" class="btn btn-link text-white">Registrarse</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <?php echo $this->include('/layout/footer.php'); ?>
</body>
</html>

