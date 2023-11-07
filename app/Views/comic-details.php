
<title><?= $comic['title'] ?></title>
<?= $this->include('layout/navbar') ?>

<?= $this->section('content') ?>

<div class="container mt-5 py-5">
    <div class="row align-items-center">
        <!-- Comic image -->
        <div class="col-lg-6 mb-4">
            <img src="<?= base_url("/images/comics/{$comic['picture']}") ?>" class="img-fluid rounded mx-auto d-block" alt="Comic image" style="max-width: 100%;" />
        </div>
        <!-- Comic details -->
        <div class="col-lg-6">
            <h3 class="mb-4"><?= $comic['title'] ?></h2>
            <p class="mb-4"><?= $comic['description'] ?></p>
            <div class="d-flex justify-content-between">
                <p class="mb-4"><strong>Año de lanzamiento:</strong> <?= $comic['year'] ?></p>
                <p class="mb-4"><strong>Categoría:</strong> <?= $comic['category'] ?></p>
            </div>
            <h4 class="font-weight-bold mb-4"><?= $comic['price'] ?>€</h3>
            <button class="btn btn-danger btn-lg">Añadir al carro</button>
        </div>
    </div>
</div>




