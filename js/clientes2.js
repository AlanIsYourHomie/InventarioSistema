$(document).ready(function () {
    load(1);
});

function load(page) {
    var q = $("#q").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: './ajax/buscar_clientes.php?action=ajax&page=' + page + '&q=' + q,
        beforeSend: function (objeto) {
            $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
        },
        success: function (data) {
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');

        }
    })
}

$("#guardar_cliente2").submit(function (event) {
    $('#guardar_datos2').attr("disabled", true);

    var parametros2 = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/nuevo_cliente2.php",
        data: parametros2,
        beforeSend: function (objeto) {
            $("#resultados_ajax2").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados_ajax2").html(datos);
            $('#guardar_datos2').attr("disabled", false);
            load(1);
        }
    });
    event.preventDefault();
})



$("#editar_cliente2").submit(function (event) {
    $('#actualizar2').attr("disabled", true);

    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/editar_clientes2.php",
        data: parametros,
        beforeSend: function (objeto) {
            $("#resultados_ajax22").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados_ajax22").html(datos);
            $('#actualizar2').attr("disabled", false);
            load(1);
        }
    });
    event.preventDefault();
})


//$('#myModal3').on('show.bs.modal', function (event) {
//  var button = $(event.relatedTarget) // Button that triggered the modal
//var nombre = button.data('nombre')
//var descripcion = button.data('descripcion')
// var id = button.data('id')
// var modal = $(this)
// modal.find('.modal-body #mod_nombre').val(nombre)
// modal.find('.modal-body #mod_descripcion').val(descripcion)
// modal.find('.modal-body #mod_id').val(id)
//})


