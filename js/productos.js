$(document).ready(function () {
	load(1);
});

function load(page) {
	var q = $("#q").val();
	var idCategoria = $("#idCategoria").val();
	var parametros = { 'action': 'ajax', 'page': page, 'q': q, 'idCategoria': idCategoria };
	$("#loader").fadeIn('slow');
	$.ajax({
		data: parametros,
		url: './ajax/buscar_productos.php',
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
	if (confirm("Realmente deseas eliminar el producto")) {
		$.ajax({
			type: "GET",
			url: "./ajax/buscar_productos.php",
			data: "id=" + id, "q": q,
			beforeSend: function (objeto) {
				$("#resultados").html("Mensaje: Cargando...");
			},
			success: function (datos) {
				var result = JSON.parse(datos);

				// Mostrar el mensaje de la respuesta
				alert(result.message);

				// Verificar si la eliminación fue exitosa antes de redirigir
				if (result.status === "success") {
					// Redirigir a prueba.php
					window.location.href = "prueba.php";
				}

				// Cargar nuevamente los resultados si es necesario
				load(1);
			}
		});
	}
}








