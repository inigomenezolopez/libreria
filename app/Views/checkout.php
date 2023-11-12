<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<title>Checkout</title>

<div class="container mt-5 py-5">
    <div class="row">
        <!-- Resumen de la compra -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Resumen de la compra</h4>
                </div>
                <div class="card-body">
                    <?php $total = 0; ?>
                    <?php foreach ($comics as $comic) : ?>
                        <div class="d-flex justify-content-between my-3">
                            <h5><?= $comic['title'] ?></h5>
                            <h6 class="font-weight-bold"><?= $comic['price'] ?>€</h6>
                        </div>
                        <?php $total += $comic['price']; ?>
                    <?php endforeach; ?>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <h5>Total:</h5>
                        <h5><?= $total ?>€</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del usuario -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="mb-0">Mi información</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h5 class="mb-0"><?= $user['name'] ?></h5>
                    </div>
                    <div class="mb-3">
                        <h6 class="mb-0"><?= $user['email'] ?></h6>
                    </div>
                    <div class="mb-3">
                        <p class="mb-0">Los cómics se enviarán a este email</p>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-center">
                    <form action="<?= base_url(route_to('pay')) ?>" method="post">
                        <button type="submit" class="btn btn-success btn-lg">Pagar</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>