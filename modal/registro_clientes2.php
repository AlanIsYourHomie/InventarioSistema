<?php
if (isset($con)) {
    ?>
    <!-- Modal -->
    <div class="modal fade" id="nuevoCliente2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i> Agregar Nuevo
                        Cliente</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="guardar_cliente2" name="guardar_cliente2">
                        <div id="resultados_ajax2"></div>
                        <div class="mb-3">
                            <label for="razon" class="col-sm-2 col-form-label">Razon Social</label>
                            <input type="text" class="form-control" id="razon" name="razon" required>
                        </div>
                        <div class="mb-3">
                            <label for="direccion2" class="form-label">Dirección</label>
                            <input class="form-control" id="direccion2" name="direccion2" required>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="ruc" class="form-label">RUC</label>
                                    <input type="number" class="form-control" id="ruc" name="ruc" required maxlength="11">
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
                                    <label for="telefono" class="form-label">Telefono</label>
                                    <input type="number" class="form-control" id="telefono" name="telefono" required
                                        maxlength="9">
                                </div>
                                <script>
                                    document.getElementById("telefono").addEventListener("input", function () {
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
                                    <label for="" class="form-label">Departamento</label>
                                    <select name="departamento2" class="form-select" id="sel_departamento2" required>
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
                                    <select name="provincia2" class="form-select" id="sel_provincia2" disabled
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
                                    <select name="distrito2" class="form-select" id="sel_distrito2" disabled
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
                    <button type="submit" class="btn btn-primary" id="guardar_datos2">Guardar datos</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}
?>