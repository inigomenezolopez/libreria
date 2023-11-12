<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<title>Búsqueda de comics</title>
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

<div class="container-fluid vh-100 d-flex flex-column">
    <div class="row flex-grow-1">
        <div class="col-md-3 bg-light p-3 d-flex flex-column justify-content-start">
            <div class="mb-5 pt-5 text-center">
                <h4 class="mb-3">Filtrar por categorías</h4>
                <div class="list-group mb-5 d-flex flex-column align-items-center">
                    <?php foreach ($categories as $category) : ?>
                        <a href="<?= base_url(route_to('todos-los-comics')) ?>?category=<?= $category['category'] ?>" class="d-inline-block text-decoration-none mb-2 p-2 text-dark text-center" style="width: 50%; border-radius: 15px; transition: background-color 0.3s ease; background-color: transparent; border: 1px solid #dc3545;" onmouseover="this.style.backgroundColor='#ff7f7f';" onmouseout="this.style.backgroundColor='transparent';"><?= $category['category'] ?></a>
                    <?php endforeach; ?>
                </div>

                <h4 class="mb-3">Buscar por título</h4>
                <form action="<?= base_url(route_to('search-comics')) ?>" method="get">
                    <input class="form-control" name="title" type="search">
                    <input type="submit" value="Buscar" class="btn btn-danger mt-2">
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
                                                <h4 class="font-weight-bold"><?= $comic['price'] ?>€</h4>
                                            </div>
                                            <!-- Botón de más detalles -->
                                            <div class="mt-2 d-flex justify-content-center">
                                                <a href="<?= base_url("/comics/{$comic['id']}") ?>" class="btn btn-danger">Más detalles</a>
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

<?= $this->endSection() ?>