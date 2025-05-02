$(document).ready(function () {
    load(1);
});

$("#registro").submit(function (event) {
    $('#enviar_datos').attr("disabled", true);

    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "ajax/nuevo_usuario_login.php",
        data: parametros,
        beforeSend: function (objeto) {
            $("#resultados_ajax").html("Mensaje: Cargando...");
        },
        success: function (datos) {
            if (datos.includes("Error")) {
                // Si la respuesta contiene la palabra "Error", se considera un mensaje de error
                $("#mensaje-error").html(datos).show();
                $("#mensaje-exito").hide();
            } else {
                // Si no hay errores, oculta el mensaje de error y muestra el mensaje de éxito
                $("#mensaje-error").hide();
                $("#mensaje-exito").html("¡Registro exitoso!").show();
            }

            $("#resultados_ajax").html(datos);
            $('#enviar_datos').attr("disabled", false);
            load(1);
        }
    });
    event.preventDefault();
});