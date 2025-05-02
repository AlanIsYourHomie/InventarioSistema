<form class="form-horizontal" method="post">
  <!-- Modal -->
  <div id="remove-stock" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Eliminar Stock</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="mb-3">
            <label for="quantity_remove" class="form-label">Cantidad</label>
            <input type="number" min="1" name="quantity_remove" class="form-control" id="quantity_remove" value=""
              placeholder="Cantidad" required="">
          </div>
          <div class="mb-3">
            <label for="reference_remove" class="form-label">Referencia</label>
            <input type="text" name="reference_remove" class="form-control" id="reference_remove" value=""
              placeholder="Referencia">
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar datos</button>
        </div>
      </div>

    </div>
  </div>
</form>