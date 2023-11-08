<?= $this->include('layout/navbar') ?>

<title>Carrito de la compra</title>
<style>
    .pagination .active .page-link {
        background-color: #dc3545;
        /* Bootstrap btn-danger red */
        border-color: #dc3545;
        /* Bootstrap btn-danger red */
        color: white;
        /* White text */
    }

    .pagination .page-link {
        color: black;
        /* Black text */
    }

    .pagination .page-link:hover {
        background-color: #dc3545;
        /* Bootstrap btn-danger red */
        color: white;
        /* White text */
    }
</style>
<div class="container mt-5 py-5">
    <?php if (empty($comics)) : ?>
        <h2 class="text-center">Carrito vacío</h2>

    <?php else : ?>
        <?php $total = 0; ?>
        <?php foreach ($comics as $comic) : ?>
            <div class="row mb-4 align-items-center border p-3">
                <!-- Comic image -->
                <div class="col-md-2">
                    <img src="<?= base_url("/images/comics/{$comic['picture']}") ?>" class="img-fluid rounded mx-auto d-block" alt="Comic image" style="max-width: 50%;" />
                </div>
                <!-- Comic details -->
                <div class="col-md-8">
                    <h5><?= $comic['title'] ?></h5>
                    <h6 class="font-weight-bold"><?= $comic['price'] ?>€</h6>
                </div>
                <!-- Remove from cart button -->
                <div class="col-md-2">
                    <button class="btn btn-danger btn-sm" onclick="location.href='<?= site_url('cart/remove/' . $comic['id']) ?>'">Quitar del carro</button>
                </div>
            </div>
            <?php $total += $comic['price']; ?>
        <?php endforeach; ?>
        <!-- Total price -->
        <div class="row justify-content-end">
            <div class="col-md-2">
                <h5>Total: <?= $total ?>€</h5>
            </div>
        </div>
        <!-- Pay button -->
        <div class="row justify-content-end">
            <div class="col-md-2">
                <button class="btn btn-success btn-sm" onclick="location.href='<?= site_url('checkout') ?>'">Pagar</button>

            </div>
        </div>
    <?php endif; ?>
</div>