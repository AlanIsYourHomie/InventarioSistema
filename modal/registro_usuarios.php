<?php
if (isset($con)) {
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i> Agregar nuevo usuario
					</h4>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form method="post" id="guardar_usuario" name="guardar_usuario"
						onsubmit="seleccionGenero(event) || seleccionEstado(event)">
						<div id="resultados_ajax"></div>
						<div class="mb-3 row">
							<label for="nombre" class="col-sm-2 col-form-label">Nombres</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="nombre" name="nombre" required>
							</div>
						</div>
						<div class="mb-3 row">
							<label for="lastname" class="col-sm-2 col-form-label">Apellidos</label>
							<div class="col-sm-10">
								<div class="input-group">
									<input type="text" class="form-control" id="apepaterno" name="apepaterno"
										placeholder="Paterno" required>
									<input type="text" class="form-control" id="apematerno" name="apematerno"
										placeholder="Materno" required>
								</div>
								<script>
									$(document).ready(function () {
										// Obtener los inputs
										const apePaterno = $("#apepaterno");
										const apeMaterno = $("#apematerno");

										// Agregar un evento keydown a los inputs
										apePaterno.on("keydown", function (event) {
											// Obtener el valor del input
											const valor = $(this).val();

											// Si el usuario presiona la tecla espacio, evitar que escriba más caracteres
											if (event.keyCode === 32) {
												event.preventDefault();
											}
										});

										apeMaterno.on("keydown", function (event) {
											// Obtener el valor del input
											const valor = $(this).val();

											// Si el usuario presiona la tecla espacio, evitar que escriba más caracteres
											if (event.keyCode === 32) {
												event.preventDefault();
											}
										});
									});

								</script>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="mb-3">
									<label for="nombre_usuario" class="form-label">Usuario</label>
									<input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario"
										pattern="[a-zA-Z0-9]{2,64}"
										title="Nombre de usuario (sólo letras y números, 2-64 caracteres)" required>
								</div>
							</div>
							<div class="col-6">
								<div class="mb-3">
									<label for="usuario_email" class="form-label">Email</label>
									<input type="email" class="form-control" id="usuario_email" name="usuario_email"
										required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="mb-3">
									<label for="user_password_new" class="form-label">Contraseña</label>
									<input type="password" class="form-control" id="user_password_new"
										name="user_password_new" pattern=".{6,}" title="Contraseña (mín. 6 caracteres)"
										required>
								</div>
							</div>
							<div class="col-6">
								<div class="mb-3">
									<label for="user_password_repeat" class="form-label">Repite contraseña</label>
									<input type="password" class="form-control" id="user_password_repeat"
										name="user_password_repeat" pattern=".{6,}" required>
								</div>
							</div>
						</div>
						<div class="mb-3">
							<label for="direccion" class="form-label">Dirección</label>
							<input class="form-control" id="direccion" name="direccion" required>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="mb-3">
									<label for="dni" class="form-label">DNI</label>
									<input type="number" class="form-control" id="dni" name="dni" required maxlength="8">
								</div>
								<script>
									document.getElementById("dni").addEventListener("input", function () {
										let dniInput = this.value.trim();
										if (dniInput.length === 8 && !isNaN(dniInput)) {
										} else {
											this.value = dniInput.slice(0, 8);
										}
									});
								</script>
							</div>
							<div class="col-6">
								<div class="mb-3">
									<label for="celular" class="form-label">Celular</label>
									<input type="number" class="form-control" id="celular" name="celular" required
										maxlength="9">
								</div>
								<script>
									document.getElementById("celular").addEventListener("input", function () {
										let dniInput = this.value.trim();
										if (dniInput.length === 9 && !isNaN(dniInput)) {
										} else {
											this.value = dniInput.slice(0, 9);
										}
									});
								</script>
							</div>
						</div>
						<div class="row">
							<div class="col-4">
								<div class="mb-3">
									<label for="fecnac" class="form-label">Fec. Nacimiento</label>
									<input type="text" class="form-select" id="fecnac" name="fecnac" required>
								</div>
								<script>
									flatpickr("#fecnac", {
										dateFormat: "Y-m-d",
										defaultDate: "01-01-2000"
									});
								</script>
							</div>
							<div class="col-4">
								<div class="mb-3">
									<label for="sexo" class="form-label">Género</label>
									<select class="form-select" id="sexo" name="sexo" required>
										<option value="masculino">Masculino</option>
										<option value="masculino">Femenino</option>
										<option value="masculino">Otro</option>
									</select>
								</div>
							</div>
							<div class="col-4">
								<div class="mb-3">
									<label for="estado" class="form-label">Estado Civil</label>
									<select class="form-select" id="estado" name="estado" required>
										<option value="soltero/a">Soltero/a</option>
										<option value="Casado/a">Casado/a</option>
										<option value="Separado/a">Separado/a</option>
										<option value="Viudo/a">Viudo/a</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="mb-3">
									<label for="cargo" class="form-label">Cargo</label>
									<select class="form-select" id="cargo" name="cargo" required>
										<?php
										$query_categoria = mysqli_query($con, "select * from cargo order by nomCargo");
										while ($rw = mysqli_fetch_array($query_categoria)) {
											?>
											<option value="<?php echo $rw['idCargo']; ?>">
												<?php echo $rw['nomCargo']; ?>
											</option>
											<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-6">
								<div class="mb-3">
									<label for="area" class="form-label">Area</label>
									<select class="form-select" id="area" name="area" required>
										<?php
										$query_categoria = mysqli_query($con, "select * from area order by nomArea");
										while ($rw = mysqli_fetch_array($query_categoria)) {
											?>
											<option value="<?php echo $rw['idArea']; ?>">
												<?php echo $rw['nomArea']; ?>
											</option>
											<?php
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-4">
								<div class="mb-3">
									<label for="" class="form-label">Departamento</label>
									<select name="departamento" class="form-select" id="sel_departamento" required>
										<option value="" selected disabled>Seleccione Departamento</option>
										<?php
										$query_departamento = mysqli_query($con, "SELECT * FROM departamento ORDER BY Nom_Departamento");
										while ($rw = mysqli_fetch_array($query_departamento)) {
											echo "<option value='{$rw['idDepartamento']}'>{$rw['Nom_Departamento']}</option>";
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-4">
								<div class="mb-3">
									<label for="" class="form-label">Provincia</label>
									<select name="provincia" class="form-select" id="sel_provincia" disabled
										required></select>
								</div>
							</div>
							<div class="col-4">
								<div class="mb-3">
									<label for="" class="form-label">Distrito</label>
									<select name="distrito" class="form-select" id="sel_distrito" disabled
										required></select>
								</div>
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