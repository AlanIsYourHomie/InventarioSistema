<?php if (isset($con)) { ?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="exampleModalLabel"><i class='bi bi-pencil'></i> Agregar nuevo producto</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form class="form" method="post" id="guardar_producto" name="guardar_producto"
						enctype="multipart/form-data">
						<div id="resultados_ajax_productos"></div>
						<div class="row mb-3">
							<label for="codigo" class="col-sm-2 col-form-label text-end">Código</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="codigo" name="codigo"
									placeholder="Código del producto" required>
							</div>
						</div>

						<div class="row mb-3">
							<label for="nombre" class="col-sm-2 col-form-label text-end">Nombre</label>
							<div class="col-sm-10">
								<textarea class="form-control" id="nombre" name="nombre" placeholder="Nombre del producto"
									required maxlength="255"></textarea>
							</div>
						</div>

						<div class="row mb-3">
							<label for="categoria" class="col-sm-2 col-form-label text-end">Categoría</label>
							<div class="col-sm-10">
								<select class="form-select" name="categoria" id="categoria" required>
									<option value="">Selecciona una categoría</option>
									<?php
									$query_categoria = mysqli_query($con, "select * from categoria order by nom_categoria");
									while ($rw = mysqli_fetch_array($query_categoria)) {
										?>
										<option value="<?php echo $rw['idCategoria']; ?>">
											<?php echo $rw['nom_Categoria']; ?>
										</option>
										<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="row mb-3">
							<label for="marca" class="col-sm-2 col-form-label text-end">Marca</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="marca" name="marca"
									placeholder="Marca del Procuto" required>
							</div>
						</div>
						<div class="row mb-3">
							<label for="precio" class="col-sm-2 col-form-label text-end">Precio</label>
							<div class="col-sm-10">
								<input type="number" class="form-control" id="precio" name="precio"
									placeholder="Precio de venta del producto" required
									pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales"
									maxlength="8">
							</div>
						</div>

						<div class="row mb-3">
							<label for="stock" class="col-sm-2 col-form-label text-end">Stock</label>
							<div class="col-sm-10">
								<input type="number" min="0" class="form-control" id="stock" name="stock"
									placeholder="Inventario inicial" required maxlength="8">
							</div>
						</div>
						<div class="row mb-3">
							<label for="imagen" class="col-sm-2 col-form-label text-end">Referencia:</label>
							<div class="col-sm-10">
								<input type="file" class="form-control" id="imagen" name="imagen" required>
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
<?php } ?>