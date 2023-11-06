<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<!-- Bootstrap icons-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
<!-- Core theme CSS (includes Bootstrap)-->
<link href="<?php echo base_url('public/assets/'); ?> css/styles.css" rel="stylesheet" />

<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<!-- Header-->
<header class="bg-dark py-3">
    <div class="container px-4 px-lg-5 d-flex flex-column justify-content-end" style="height: 16vh;">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder" style="font-size: 2.5rem;">Explora mundos desconocidos</h1>
            <p class="lead">Embárcate en un viaje lleno de aventuras y descubrimientos.</p>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <button class="btn btn-danger text-white">Descubre más</button>
        </div>
    </div>
</header>








<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <!-- Itera sobre los cómics -->
            <?php if (isset($comics) && is_array($comics)) : ?>
                <?php foreach ($comics as $comic) : ?>
                    <div class="col mb-5 d-flex justify-content-center">
                        <div class="card" style="width: 230px;">
                            <!-- Product image-->
                            <div style="height: 350px;">
                                <img class="card-img-top img-fluid rounded" style="height: 100%; width: 100%; object-fit: cover;" src="<?= base_url("/images/comics/{$comic['picture']}") ?>" alt="..." />
                            </div>
                            <!-- Product details-->
                            <div class="card-body p-2 d-flex flex-column">
                                <div class="text-center mb-auto">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><?= $comic['title'] ?></h5>
                                </div>
                                <div class="text-center mt-auto">
                                    <!-- Product price-->
                                    <?= $comic['price'] ?>€
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No se encontraron cómics.</p>
            <?php endif; ?>
        </div>
    </div>
</section>













<?= $this->endSection() ?>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="<?php echo base_url('public/assets/'); ?>js/scripts.js"></script>