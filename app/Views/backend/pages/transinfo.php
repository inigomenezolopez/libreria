<?= $this->extend("backend/layout/pages-layout") ?>
<?= $this->section("content") ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Transacciones</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url(route_to('admin.home')) ?>">Inicio</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Historial de transacciones
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card card-box">
            <div class="card-header">
                <div class="clearfix">
                    <div class="pull-left">
                        Historial de transacciones
                    </div>

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-borderless table-hover table-striped w-100" id="transinfo-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Email del usuario</th>
                                <th scope="col">Título del cómic</th>
                                <th scope="col">Pago total</th>
                                <th scope="col">Fecha de la compra</th>


                            </tr>
                        </thead>
                        <tbody></tbody>
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
     var posts_DT = $('table#transinfo-table').DataTable({
        // que aparezca el detalle de transacción
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.22/i18n/Spanish.json'
        },
        scrollCollapse:true,
        responsive:true,
        autoWidth:false,
        processing:true,
        serverSide:true,
        ajax:"<?= base_url(route_to('get-trans-info')) ?>",
        "dom":"IBfrtip",
        info:true,
        fnCreatedRow:function(row, data, index) {
            $('td', row).eq(0).html(index+1);
        },
        columDefs:[
            {orderable:false, targets:[0, 1, 2, 3, 4]}
        ]
    });
</script>

<?= $this->endSection() ?>