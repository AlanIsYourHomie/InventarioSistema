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

function eliminar(id) {
    var q = $("#q").val();
    if (confirm("¿Realmente deseas eliminar al cliente?")) {
        $.ajax({
            type: "GET",
            url: "./ajax/buscar_clientes.php",
            data: "id=" + id, "q": q,
            beforeSend: function (objeto) {
                $("#resultados").html("Mensaje: Cargando...");
            },
            success: function (datos) {
                $("#resultados").html(datos);
                load(1);
            }
        });
    }
}



$("#guardar_cliente").submit(function (event) {
    $('#guardar_datos').attr("disabled", true);

    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/nuevo_cliente.php",
        data: parametros,
        beforeSend: function (objeto) {
            $("#resultados_ajax").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados_ajax").html(datos);
            $('#guardar_datos').attr("disabled", false);
            load(1);
        }
    });
    event.preventDefault();
})



$("#editar_cliente").submit(function (event) {
    $('#actualizar1').attr("disabled", true);

    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/editar_clientes.php",
        data: parametros,
        beforeSend: function (objeto) {
            $("#resultados_ajax10").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            $("#resultados_ajax10").html(datos);
            $('#actualizar1').attr("disabled", false);
            load(1);
        }
    });
    event.preventDefault();
})


function obtener_datos(id) {
    var apepaterno = $("#apepaterno" + id).val();
    var apematerno = $("#apematerno" + id).val();
    var nombre_persona = $("#nombre_persona" + id).val();
    var dni = $("#dni" + id).val();
    var sexo = $("#sexo" + id).val();
    var direccion = $("#direccion" + id).val();
    var estado_civil = $("#estado_civil" + id).val();
    var celular = $("#celular" + id).val();
    var idDistrito = $("#idDistrio" + id).val();
    var fecnac = $("#fecnac" + id).val();

    $("#idPersona3").val(id);
    $("#nombre3").val(nombre_persona);
    $("#apepaterno3").val(apepaterno);
    $("#apematerno3").val(apematerno);
    $("#dni3").val(dni);
    $("#sexo3").val(sexo);
    $("#direccion3").val(direccion);
    $("#estado3").val(estado_civil);
    $("#celular3").val(celular);
    $("#distrito3").val(idDistrito);
    $("#fecnac3").val(fecnac);
}

function obtener_datos2(id) {
    var razonSocial = $("#razonSocial" + id).val();
    var direccion2 = $("#direccion2" + id).val();
    var ruc = $("#ruc" + id).val();
    var telefono = $("#telefono" + id).val();

    $("#idempresa3").val(id);
    $("#razon4").val(razonSocial);
    $("#direccion4").val(direccion2);
    $("#ruc4").val(ruc);
    $("#telefono4").val(telefono);
}

//$('#myModal2').on('show.bs.modal', function (event) {
//var button = $(event.relatedTarget) // Button that triggered the modal
//var nombre = button.data('nombre')
//var apepaterno = button.data('apepaterno')
//var apematerno = button.data('apematerno')
//var direccion = button.data('direccion')
//var dni = button.data('dni')
//var celular = button.data('celular')
// var fecnac = button.data('fecnac')
//var sexo = button.data('sexo')
// var estado = button.data('estado')
//var distrito = button.data('distrito')
//var idpersona = button.data('idpersona')

//var modal = $(this)
//modal.find('.modal-body #nombre3').val(nombre)
//modal.find('.modal-body #apepaterno3').val(apepaterno)
//modal.find('.modal-body #apematerno3').val(apematerno)
//modal.find('.modal-body #direccion3').val(direccion)
//modal.find('.modal-body #dni3').val(dni)
// modal.find('.modal-body #celular3').val(celular)
//modal.find('.modal-body #fecnac3').val(fecnac)
//modal.find('.modal-body #sexo3').val(sexo)
//modal.find('.modal-body #estado3').val(estado)
//modal.find('.modal-body #idpersona3').val(idpersona)
//modal.find('.modal-body #distrito').val(distrito)
//})


