<?= $this->extend("backend/layout/pages-layout") ?>
<?= $this->section("content") ?>
<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Añadir cómic</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url(route_to('admin.home')) ?>">Inicio</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Añadir cómic
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a href="<?= base_url(route_to('all-comics')) ?>" class="btn btn-primary">Ver todos los cómics</a>
        </div>
    </div>
</div>

<form action="<?= base_url(route_to('create-comic')) ?>" method="post" autocomplete="off" enctype="multipart/form-data" id="AddComicForm">
    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" class="ci_csrf_data">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-box mb-2">
                <div class="card-body">
                    <div class="form-group">
                        <label for=""><b>Título del cómic</b></label>
                        <input type="text" class="form-control" placeholder="Introduce el nombre del cómic" name="title">
                        <span class="text-danger error-text title_error"></span>
                    </div>
                    <div class="form-group">
                        <label for=""><b>Descripción</b></label>
                        <textarea name="content" id="" cols="30" rows="10" class="form-control" placeholder="Escribe la descripción del cómic"></textarea>
                        <span class="text-danger error-text content_error"></span>
                    </div>
                    <div class="form-group">
                        <label for=""><b>Precio</b></label>
                        <input type="number" step="0.01" class="form-control" placeholder="Introduce el precio del cómic" name="price">
                        <span class="text-danger error-text price_error"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-box mb-2">
                <div class="card-body">
                    <div class="form-group">
                        <label for=""><b>Año</b></label>
                        <input type="number" class="form-control" placeholder="Introduce el año del cómic" name="year">
                        <span class="text-danger error-text price_error"></span>
                    </div>
                    <div class="form-group">
                        <label for=""><b>Escoge la categoría</b></label>
                        <select name="category" id="" class="custom-select form-control">
                            <option value="">Elige...</option>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?= $category->category ?>"> <?= $category->category ?> </option>
                            <?php endforeach ?>
                        </select>
                        <span class="text-danger error-text category_error"></span>
                    </div>

                    <div class="from-group">
                        <label for=""><b>Imagen de la portada</b></label>
                        <input type="file" name="featured_image" class="form-control-file form-control" height="auto">
                        <span class="text-danger error-text featured_image_error"></span>
                    </div>
                    <div class="d-block mb-3" style="max-width: 250px; margin: auto;">
                        <img src="" alt="" class="img-thumbnail" id="image-previewer" data-ijabo-default-img="">
                    </div>
                    <div class="mb-3">

                    </div>

                </div>
                <button type="submit" class="btn btn-primary">Añadir cómic</button>
            </div>
        </div>

    </div>

</form>




<?= $this->endSection() ?>

<?= $this->section('stylesheets') ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
    $('input[type="file"][name="featured_image"]').ijaboViewer({
        preview: '#image-previewer',
        imageShape: 'any',
        allowedExtensions: ['jpg', 'png', 'jpeg'],
        onErrorShape: function(message, element) {
            alert(message);
        },
        onInvalidType: function(message, element) {
            alert(message);
        }
    });

    $('#AddComicForm').on('submit', function(e) {
        e.preventDefault();
        var csrfName = $('.ci_csrf_data').attr('name'); //csrf token name
        var csrfHash = $('.ci_csrf_data').val(); // csrf hash
        var form = this;
        var formdata = new FormData(form)
        formdata.append(csrfName, csrfHash);

        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: formdata,
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function() {
                toastr.remove();
                $(form).find('span.error-text').text('');
            },
            success: function(response) {
                // update csrf hash
                $('.ci_csrf_data').val(response.token);

                if ($.isEmptyObject(response.error)) {
                    if (response.status == 1) {
                        $(form)[0].reset();
                        $('img#image-previewer').attr('src', '');
                        toastr.success(response.msg)
                    } else {
                        toastr.error(response.msg);

                    }
                } else {
                    $.each(response.error, function(prefix, val) {
                        $(form).find('span.' + prefix + '_error').text(val);
                    });
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>