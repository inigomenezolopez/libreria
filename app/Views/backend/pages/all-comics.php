<?= $this->extend("backend/layout/pages-layout") ?>
<?= $this->section("content") ?>
<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Todos los cómics</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url(route_to('admin.home')) ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Todos los cómics
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <div class="dropdown">
                <a class="btn btn-primary" href="<?= base_url(route_to('new-comic')) ?>">
                    Añadir nuevo cómic
                </a>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card card-box">
            <div class="card-header">
                <div class="clearfix">
                    <div class="pull-left">Todos los cómics</div>
                    <div class="pull-right"></div>
                </div>
            </div>
            <div class="card-body">
                <table class="data-table table stripe hover nowrap dataTable no-footer dtr-inline collapsed" id="comics-table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Portada</th>
                            <th scope="col">Título</th>
                            <th scope="col">Categoría</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Año</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('stylesheets') ?>
<link rel="stylesheet" href="/libreria/public/backend/src/plugins/datatables/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/libreria/public/backend/src/plugins/datatables/css/responsive.bootstrap4.min.css">
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="/libreria/public/backend/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="/libreria/public/backend/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="/libreria/public/backend/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="/libreria/public/backend/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<script>
    // que aparezcan los comics
    var posts_DT = $('table#comics-table').DataTable({ // convierte la tabla en una datatable
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.22/i18n/Spanish.json'
        },
        scrollCollapse: true,
        responsive: true,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ajax: "<?= base_url(route_to('get-comics')) ?>",
        "dom": "IBfrtip", // orden de los elementos de control de la tabla
        info: true,
        fnCreatedRow: function(row, data, index) {
            $('td', row).eq(0).html(index + 1); // se numeran las filas
        },
        columDefs: [{
            orderable: false,
            targets: [0, 1, 2, 3, 4, 5, 6, 7]
        }]
    });

    $(document).on('click', '.deleteComicBtn', function(e) {
        e.preventDefault(); // impide que haga la funcion predeterminada de click
        var comic_id = $(this).data('id'); 
        var url = "<?= base_url(route_to('delete-comic')) ?>"; 
        swal.fire({
            // Muestra un cuadro de diálogo de confirmación utilizando la biblioteca SweetAlert.
            title: '¿Estás seguro?',
            html: 'Quieres eliminar este cómic.',
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Sí, por favor',
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            width: 300,
            allowOutsideClick: false
        }).then(function(result) { // cuando el usuario hace click en uno de los botones del cuadro del dialogo
            if (result.value) {
                $.get(url, {
                    comic_id: comic_id
                }, function(response) {
                    if (response.status == 1) {
                        posts_DT.ajax.reload(null, false);
                        toastr.success(response.msg);
                    } else {
                        toastr.error(response.msg);
                    }
                }, 'json');
            }
        });
    });
</script>
<?= $this->endSection() ?>