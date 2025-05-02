<?php
if (isset($con)) {
    ?>
    <!-- Modal -->
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i> Editar
                        Cliente Persona</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="editar_cliente" name="editar_cliente">
                        <div id="resultados_ajax10"></div>
                        <div class="mb-3 row">
                            <label for="nombre3" class="col-sm-2 col-form-label">Nombres</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nombre3" name="nombre3" required>
                            </div>
                            <input type="hidden" name="idPersona3" id="idPersona3">
                        </div>
                        <div class="mb-3 row">
                            <label for="lastname" class="col-sm-2 col-form-label">Apellidos</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="apepaterno3" name="apepaterno3"
                                        placeholder="Paterno" required>
                                    <input type="text" class="form-control" id="apematerno3" name="apematerno3"
                                        placeholder="Materno" required>
                                </div>
                                <script>
                                    $(document).ready(function () {
                                        // Obtener los inputs
                                        const apePaterno = $("#apepaterno3");
                                        const apeMaterno = $("#apematerno3");

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
                        <div class="mb-3">
                            <label for="direccion3" class="form-label">Dirección</label>
                            <input class="form-control" id="direccion3" name="direccion3" required>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="dni3" class="form-label">DNI</label>
                                    <input type="number" class="form-control" id="dni3" name="dni3" required maxlength="8">
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
                                    <label for="celular3" class="form-label">Celular</label>
                                    <input type="number" class="form-control" id="celular3" name="celular3" required
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
                                    <input type="text" class="form-select" id="fecnac3" name="fecnac3" required>
                                </div>
                                <script>
                                    flatpickr("#fecnac3", {
                                        dateFormat: "Y-m-d",
                                        defaultDate: "01-01-2000"
                                    });
                                </script>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="sexo3" class="form-label">Género</label>
                                    <select class="form-select" id="sexo3" name="sexo3" required>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="estado3" class="form-label">Estado Civil</label>
                                    <select class="form-select" id="estado3" name="estado3" required>
                                        <option value="Soltero/a">Soltero/a</option>
                                        <option value="Casado/a">Casado/a</option>
                                        <option value="Separado/a">Separado/a</option>
                                        <option value="Viudo/a">Viudo/a</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Departamento</label>
                                    <select name="departamento3" class="form-select" id="sel_departamento3" required>
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
                                    <select name="provincia3" class="form-select" id="sel_provincia3" disabled
                                        required></select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Distrito</label>
                                    <select name="distrito3" class="form-select" id="sel_distrito3" disabled
                                        required></select>
                                </div>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="actualizar1">Guardar datos</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}
?>