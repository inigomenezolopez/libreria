<?= $this->include('layout/navbar') ?>
<title>Mi perfil</title>
<div class="container mt-5 pt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashdata('success') ?>
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
              <input type="text" class="form-control" name="name" id="name" value="<?= $user['name'] ?>" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" value="<?= $user['email'] ?>" disabled>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Cambiar contraseña</label>
              <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
              <label for="bio" class="form-label">Biografía</label>
              <textarea class="form-control" id="bio" name="bio" rows="3"><?= $user['bio'] ?></textarea>
            </div>
            <button type="submit" class="btn btn-danger">Actualizar perfil</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>




