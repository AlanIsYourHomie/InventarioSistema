<?php
if (isset($con)) {
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i> Editar Contraseña
					</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="editar_password" name="editar_password">
						<div id="resultados_ajax3"></div>
						<div class="row">
							<div class="col-6">
								<label for="user_password_new3" class="form-label">Nueva contraseña</label>
								<input type="password" class="form-control" id="user_password_new3"
									name="user_password_new3" pattern=".{6,}" title="Contraseña ( min . 6 caracteres)"
									required>
								<input type="hidden" id="user_id_mod" name="user_id_mod">
							</div>
							<div class="col-6">
								<label for="user_password_repeat3" class="form-label">Repite contraseña</label>
								<input type="password" class="form-control" id="user_password_repeat3"
									name="user_password_repeat3" pattern=".{6,}" required>
							</div>
						</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" id="actualizar_datos3">Cambiar contraseña</button>
				</div>
				</form>
			</div>
		</div>
	</div>
	<?php
}
?>