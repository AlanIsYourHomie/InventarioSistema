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
                    <form method="post" id="guardar_usuario" name="guardar_usuario">
                        <div id="resultados_ajax"></div>
                        <div class="mb-3 row">
                            <label for="firstname" class="col-sm-2 col-form-label">Nombres</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="firstname" name="firstname" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="lastname" class="col-sm-2 col-form-label">Apellidos</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="lastname" name="lastname"
                                        placeholder="Paterno" required>
                                    <input type="text" class="form-control" id="lastname2" name="lastname2"
                                        placeholder="Materno" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="user_name" class="form-label">Usuario</label>
                                    <input type="text" class="form-control" id="user_name" name="user_name"
                                        pattern="[a-zA-Z0-9]{2,64}"
                                        title="Nombre de usuario (sólo letras y números, 2-64 caracteres)" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="user_email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="user_email" name="user_email" required>
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
                            <label for="adress" class="form-label">Dirección</label>
                            <input class="form-control" id="adress" name="adress" required>
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
                                    <label for="birthdate" class="form-label">Fec. Nacimiento</label>
                                    <input type="text" class="form-select" id="birthdate" name="birthdate" required>
                                </div>
                                <script>
                                    flatpickr("#birthdate", {
                                        dateFormat: "d-m-Y",
                                        defaultDate: "01-01-2000"
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="user_name" class="form-label">Género</label>
                                    <select class="form-select" id="genero" required>
                                        <option>Masculino</option>
                                        <option>Femenino</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="user_email" class="form-label">Estado Civil</label>
                                    <select class="form-select" id="estado" required>
                                        <option>Soltero/a</option>
                                        <option>Casado/a</option>
                                        <option>Separado/a</option>
                                        <option>Viudo/a</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--<div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Departamento</label>
                                    <select name="state" class="form-select " id="sel_departamento" required>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Provincia</label>
                                    <select name="state" class="form-select " id="sel_provincia" required></select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Distrito</label>
                                    <select name="state" class="form-select " id="sel_distrito" required></select>
                                </div>
                            </div>
                        </div>-->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="../js/console_ubigeo"></script>
    <script>
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
            listar_departamento();
        })
    </script>
    <?php
}
?>