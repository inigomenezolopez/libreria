<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<title>Mi perfil</title>

<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('success') ?>
            </div>
            <?php endif; ?>
            <?php if ($validationErrors = session()->getFlashdata('errors')) : ?>
            <div class="alert alert-danger" role="alert">
                <?php foreach ($validationErrors as $error) : ?>
                <?= $error ?><br>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <div class="card">
                <div class="card-header bg-danger text-white text-center">
                    <h2>Actualizar perfil</h2>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= base_url(route_to('actualizar_perfil')) ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="name" id="name"
                                value="<?= old('name', $user['name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="<?= $user['email'] ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Cambiar contraseña</label>
                            <input type="password" class="form-control" id="password" name="password"
                                value="<?= old('password') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmar cambio de contraseña</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                value="<?= old('confirm_password') ?>">
                        </div>


                        <button type="submit" class="btn btn-danger">Actualizar perfil</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>





<?= $this->endSection() ?>