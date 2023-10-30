<?= $this->extend("backend/layout/pages-layout") ?>
<?= $this->section("content") ?>

<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Categorías</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url(route_to('admin.home')) ?>">Inicio</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Categorías
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
                        Categorías
                    </div>
                    <div class="pull-right">
                        <a href="" class="btn btn-default btn-sm p-0" role="button" id="add_category_btn">
                            <i class="fa fa-plus-circle"></i> Añadir categoría
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless table-hover table-striped" id="categories-table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre de la categoría</th>
                            <th scope="col">Acción</th>

                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include('modals/category-modal-form.php') ?>

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
    $(document).on('click', '#add_category_btn', function(e) {
        e.preventDefault();
        var modal = $('body').find('div#category-modal');
        var modal_title = 'Añadir categoría';
        var modal_btn_text = 'AÑADIR';
        modal.find('.modal-title').html(modal_title);
        modal.find('.modal-footer > button.action').html(modal_btn_text);
        modal.find('input.error-text').html('');
        modal.find('input[type="text"]').val('');
        modal.modal('show');
    });

    $('#add_category_form').on('submit', function(e) {
        e.preventDefault();
        // CSRF Hash
        var csrfName = $('.ci_csrf_data').attr('name'); // csrf token name
        var csrfHash = $('.ci_csrf_data').val(); // csrf hash
        var form = this;
        var modal = $('body').find('div#category-modal');
        var formdata = new FormData(form);
        formdata.append(csrfName, csrfHash);

        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: formdata,
            processData: false,
            dataType: 'json',
            contentType: false,
            cache: false,
            beforeSend: function() {
                $(form).find('span.error-text').text('');
            },
            success: function(response) {
                // update csrf hash
                $('.ci_csrf_data').val(response.token);

                if ($.isEmptyObject(response.error)) {
                    if (response.status == 1) {
                        $(form)[0].reset();
                        modal.modal('hide');
                        toastr.success(response.msg);
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

    // retrieve categories

    var categories_DT = $('#categories-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?= base_url(route_to('get-categories')) ?>",
        dom: "Brtip",
        info: true,
        fnCreatedRow: function(row, data, index) {
            $('td', row).eq(0).html(index + 1);
        },
        columnDefs:[
            {targets:[0,1,2]},
            
        ],
        order:[[2, 'asc']]

    });
</script>
<?= $this->endSection() ?>