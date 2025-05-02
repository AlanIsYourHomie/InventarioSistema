<?php
if (isset($con)) {
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-pers" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i> Editar Usuario
					</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form method="post" id="editar_usuario" name="editar_usuario">
						<div id="resultados_ajax2"></div>
						<div class="row">
							<div class="col-6">
								<div class="mb-3">
									<label for="nombre_usuario2" class="form-label">Usuario</label>
									<input type="text" class="form-control" id="nombre_usuario2" name="nombre_usuario2"
										pattern="[a-zA-Z0-9]{2,64}"
										title="Nombre de usuario (sólo letras y números, 2-64 caracteres)" required>
									<input type="hidden" id="idUsuaruiMod" name="idUsuaruiMod">
								</div>
							</div>
							<div class="col-6">
								<div class="mb-3">
									<label for="usuario_email2" class="form-label">Email</label>
									<input type="email" class="form-control" id="usuario_email2" name="usuario_email2"
										required>
								</div>
							</div>
						</div>

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<?php
}
?>