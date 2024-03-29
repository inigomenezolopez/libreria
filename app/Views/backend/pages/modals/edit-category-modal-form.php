<div class="modal fade" id="edit-category-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="<?= base_url(route_to('update-category')) ?>" method="POST" id="update_category_form">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">
                    Large modal
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" class="ci_csrf_data">
                <input type="hidden" name="category_id">
                <div class="form-group">
                    <label for=""><b>Nombre de la categoría</b></label>
                    <input type="text" class="form-control" name="category_name" placeholder="Escribe el nombre de la categoría">
                    <span class="text-danger error-text category_name_error"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Cerrar
                </button>
                <button type="submit" class="btn btn-primary action">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>