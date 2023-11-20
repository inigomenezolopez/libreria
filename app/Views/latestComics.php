<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<title>Novedades</title>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <section class="py-1 mt-1 ">
                <div class="container px-4 px-lg-5 mt-5">
                    <h2 class="display-4 mb-4 text-center">Últimos Lanzamientos</h2>
                    <br>
                    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-3 justify-content-center">
                        <!-- Itera sobre los cómics -->
                        <?php if (isset($latestComics) && is_array($latestComics)) : ?>
                        <?php foreach ($latestComics as $comic) : ?>
                        <a href="<?= base_url("/comics/{$comic['id']}") ?>" style="text-decoration: none;">
                            <div class="col mb-5 d-flex justify-content-center">
                                <div class="card" style="width: 230px;">
                                    <!-- Imagen del producto -->
                                    <div style="height: 350px;">
                                        <img class="card-img-top img-fluid rounded"
                                            style="height: 100%; width: 100%; object-fit: cover;"
                                            src="<?= base_url("/images/comics/{$comic['picture']}") ?>" alt="..." />
                                    </div>
                                    <!-- Detalles del producto -->
                                    <div class="card-body p-2 d-flex flex-column">
                                        <div class="text-center mb-auto">
                                            <!-- Nombre del producto -->
                                            <h5 class="fw-bolder"><?= $comic['title'] ?></h5>
                                        </div>
                                        <div class="text-center mt-auto">
                                            <!-- Precio del producto -->
                                            <h4 class="font-weight-bold"><?= $comic['price'] ?>€</h4>
                                        </div>
                                        <!-- Botón de más detalles -->
                                        <div class="mt-2 d-flex justify-content-center">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; ?>
                        <?php else : ?>
                        <p>No se encontraron cómics.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>









<?= $this->endSection() ?>