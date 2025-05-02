<?php
if (isset($con)) {
    ?>
    <!-- Modal -->
    <div class="modal fade" id="nuevoPedido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class='bi bi-pencil'></i> Agregar Nuevo
                        Pedido</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" id="guardar_pedido" name="guardar_pedido">
                        <div id="resultados_ajax"></div>
                        <div class="row mb-3">
                            <label for="producto" class="col-sm-3 control-label">Producto</label>
                            <div class="col-sm-8">
                                <select class="form-select" name="producto" id="producto" required>
                                    <?php
                                    $query_pedido = mysqli_query($con, "select * from producto order by idProducto");
                                    while ($rw = mysqli_fetch_array($query_pedido)) {
                                        ?>
                                        <option value="<?php echo $rw['idProducto']; ?>">
                                            <?php echo $rw['nom_Producto']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="cantidad" class="col-sm-3 control-label">Cantidad</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="cantidad" name="cantidad"></input>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="cliente" class="col-sm-3 control-label">Cliente</label>
                            <div class="col-sm-8">
                                <select class="form-select" name="cliente" id="cliente" required>
                                    <?php
                                    $query_pedido = mysqli_query($con, "SELECT cl.idCliente,
                                    COALESCE(CONCAT(pe.ape_paterno, ' ', pe.ape_materno, ' ', pe.nombre), em.Razon_Social) AS nombres
                                    FROM cliente cl
                                    LEFT JOIN persona pe ON cl.idPersona = pe.idPersona
                                    LEFT JOIN empresa em ON cl.idEmpresa = em.idEmpresa");
                                    while ($rw = mysqli_fetch_array($query_pedido)) {
                                        ?>
                                        <option value="<?php echo $rw['idCliente']; ?>">
                                            <?php echo $rw['nombres']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
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