<?php
if (isset($con)) {
    ?>
    <!-- Modal -->
    <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i> Editar Cliente Empresa </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="editar_cliente2" name="editar_cliente2">
                        <div id="resultados_ajax22"></div>
                        <div class="mb-3">
                            <label for="razon4" class="col-sm-2 col-form-label">Razon Social</label>
                            <input type="text" class="form-control" id="razon4" name="razon4" required>
                            <input type="hidden" name="idempresa3" id="idempresa3">
                        </div>
                        <div class="mb-3">
                            <label for="direccion4" class="form-label">Dirección</label>
                            <input class="form-control" id="direccion4" name="direccion4" required>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="ruc4" class="form-label">RUC</label>
                                    <input type="number" class="form-control" id="ruc4" name="ruc4" required maxlength="11">
                                </div>
                                <script>
                                    document.getElementById("ruc").addEventListener("input", function () {
                                        let dniInput = this.value.trim();
                                        if (dniInput.length === 11 && !isNaN(dniInput)) {
                                        } else {
                                            this.value = dniInput.slice(0, 11);
                                        }
                                    });
                                </script>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="telefono4" class="form-label">Telefono</label>
                                    <input type="number" class="form-control" id="telefono4" name="telefono4" required
                                        maxlength="11">
                                </div>
                                <script>
                                    document.getElementById("telefono4").addEventListener("input", function () {
                                        let dniInput = this.value.trim();
                                        if (dniInput.length === 11 && !isNaN(dniInput)) {
                                        } else {
                                            this.value = dniInput.slice(0, 11);
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Departamento</label>
                                    <select name="departamento4" class="form-select" id="sel_departamento4" required>
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
                                    <select name="provincia4" class="form-select" id="sel_provincia4" disabled
                                        required></select>
                                    <?php
                                    if (isset($_POST['departamento_id'])) {
                                        $departamento_id = $_POST['departamento_id'];

                                        $query_provincia = mysqli_query($con, "SELECT * FROM provincia WHERE idDepartamento = $departamento_id ORDER BY Nom_Provincia");

                                        echo '<option value="" selected disabled>Provincia</option>';

                                        while ($rw = mysqli_fetch_array($query_provincia)) {
                                            echo "<option value='{$rw['idProvincia']}'>{$rw['Nom_Provincia']}</option>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Distrito</label>
                                    <select name="distrito4" class="form-select" id="sel_distrito4" disabled
                                        required></select>
                                    <?php
                                    if (isset($_POST['provincia_id'])) {
                                        $provincia_id = $_POST['provincia_id'];

                                        $query_distrito = mysqli_query($con, "SELECT * FROM distrito WHERE idProvincia = $provincia_id ORDER BY Nom_Distrito");

                                        echo '<option value="" selected disabled>Distrito</option>';

                                        while ($rw = mysqli_fetch_array($query_distrito)) {
                                            echo "<option value='{$rw['idDistrito']}'>{$rw['Nom_Distrito']}</option>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="actualizar2">Guardar datos</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}
?>