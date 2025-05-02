<?php
if (isset($con)) {
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i> Agregar nueva
						categoría</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="guardar_categoria" name="guardar_categoria">
						<div id="resultados_ajax"></div>
						<div class="row mb-3">
							<label for="nombre" class="col-sm-3 control-label">Nombre</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="nombre" name="nombre" required>
							</div>
						</div>
						<div class="row mb-3">
							<label for="descripcion" class="col-sm-3 control-label">Descripción</label>
							<div class="col-sm-8">
								<textarea class="form-control" id="descripcion" name="descripcion"
									maxlength="255"></textarea>
							</div>
						</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<?php
}
?>