<?= $this->extend("backend/layout/auth-layout") ?>
<?= $this->section("content") ?>

<div class="login-box bg-white box-shadow border-radius-10">
    <div class="login-title">
        <h2 class="text-center text-primary">Login</h2>
    </div>
    <?php $validation = \Config\Services::validation(); ?>
    <form action="<?= base_url(route_to('admin.login.handler')) ?>" method="POST">
        <?= csrf_field () ?>
        <?php if(!empty(session()->getFlashdata('success'))) : ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hiden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <?php if(!empty(session()->getFlashdata('fail'))) : ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('fail') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hiden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <div class="input-group custom">
            <input type="email" class="form-control form-control-lg" placeholder="Email" name="email" value="<?= set_value('email') ?>"> <!-- por si luego hay que cambiarlo con mi base de datos -->
            <div class="input-group-append custom">
                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
            </div>
        </div>

        <?php if($validation->getError('email')):?>  <!-- por si luego hay que cambiarlo con mi base de datos -->
            <div class="d-block text-danger" style="margin-top:-25px;margin-bottom:15px;">
                <?= $validation->getError('email') ?>
            </div>
            <?php endif; ?>
            <div class="input-group custom">
            <input type="password" class="form-control form-control-lg" placeholder="**********" name="password" value="<?= set_value('password')?>">
            <div class="input-group-append custom">
                <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
            </div>
        </div>
        <?php if($validation->getError('password')):?>  <!-- por si luego hay que cambiarlo con mi base de datos -->
            <div class="d-block text-danger" style="margin-top:-25px;margin-bottom:15px;">
                <?= $validation->getError('password') ?>
            </div>
            <?php endif; ?>
        <div class="row pb-30">
            <div class="col-6">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">Recuérdame</label>
                </div>
            </div>
            <div class="col-6">
                <div class="forgot-password">
                    <a href="<?= base_url(route_to('admin.forgot.form')) ?>">¿Se olvidó la contraseña?</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="input-group mb-0">
                    

				    <input class="btn btn-primary btn-lg btn-block" type="submit" value="Iniciar sesión">
										
                </div>
               
            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>