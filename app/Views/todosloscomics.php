<?= $this->include('layout/navbar') ?>

<?= $this->section('content') ?>

<div class="container-fluid vh-100 d-flex flex-column">
    <div class="row flex-grow-1">
        <div class="col-md-3 bg-light p-3 d-flex flex-column justify-content-start">
            <div class="mb-5 pt-3"> <!-- Añadido 'pt-3' para dar un margen superior -->
                <h5>Filtrar por categorías</h5>
                <div class="list-group mb-5"> <!-- Aumentado a 'mb-5' para dar un mayor margen inferior -->
                    <?php foreach ($categories as $category) : ?>
                        <a href="<?= base_url(route_to('todos-los-comics')) ?>?category=<?= $category['category'] ?>" class="list-group-item list-group-item-action"><?= $category['category'] ?></a>
                    <?php endforeach; ?>
                </div>

                <h5 class="mb-3">Buscar por título</h5>
                <form action="<?= base_url(route_to('search-comics')) ?>" method="get"> <!-- Aumentado a 'mt-5' para dar un mayor margen superior -->
                    <input class="form-control" name="title" type="search" placeholder="Buscar" aria-label="Buscar">
                    <input type="submit" value="Buscar" class="btn btn-primary mt-2">
                </form>
            </div>
        </div>

        <!-- Lista de cómics -->
        <div class="col-md-9">
            <section class="py-1 mt-1">
                <div class="container px-4 px-lg-5 mt-5">
                    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                        <!-- Itera sobre los cómics -->
                        <?php if (isset($comics) && is_array($comics)) : ?>
                            <?php foreach ($comics as $comic) : ?>
                                <div class="col mb-5 d-flex justify-content-center">
                                    <div class="card" style="width: 230px;">
                                        <!-- Imagen del producto -->
                                        <div style="height: 350px;">
                                            <img class="card-img-top img-fluid rounded" style="height: 100%; width: 100%; object-fit: cover;" src="<?= base_url("/images/comics/{$comic['picture']}") ?>" alt="..." />
                                        </div>
                                        <!-- Detalles del producto -->
                                        <div class="card-body p-2 d-flex flex-column">
                                            <div class="text-center mb-auto">
                                                <!-- Nombre del producto -->
                                                <h5 class="fw-bolder"><?= $comic['title'] ?></h5>
                                            </div>
                                            <div class="text-center mt-auto">
                                                <!-- Precio del producto -->
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
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $pager->getPageCount(); $i++) : ?>
                                <li class="page-item <?= $i == $pager->getCurrentPage() ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= $pager->getPageURI($i) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                </div>
            </section>
        </div>
    </div>
</div>

</div>
</div>