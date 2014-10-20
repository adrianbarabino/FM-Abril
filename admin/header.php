<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title; ?></title>
	<!-- Añadimos el TinyMCE, el editor WYSIWYG -->
	<script src="http://tinymce.cachefly.net/4.0/tinymce.min.js"></script>
	<!-- Incluimos jQuery y jQueryUI -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<!-- Cargamos nuestro DateTime Picker -->
	<script src="./jquery.datetimepicker.js"></script>
	<!-- Cargamos la traduccion -->
	<script src="./jquery.datepicker.spanish.js"></script>
	<link rel="stylesheet" href="./css/estilos.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
	<link href="http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
	<link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet">

	 <script>
	 // Cuando el documnto está listo, ejecutamos la función init..
	 $(document).on("ready", init);

	 function init (info) {
	 	$(document).on("click", "input[name=limpiar]", function () {
	 		// Poner el valor de la mayoria de los campos en nada ("")
	 		$("form > input").attr("value", "");
	 		$("form > textarea").attr("value", "");
	 		$("form > input[name=limpiar]").attr("value", "limpiar");
	 		$("form > input[name=enviar]").attr("value", "enviar");
	 	})
	 	// A todos los input que tengan name fecha y fecha ingreso los convertimos en un objeto DateTimePicker

	 	$('input[name="fecha"], input[name="fecha_ingreso"]').datetimepicker({ dateFormat: 'yy-mm-dd', timeFormat: 'hh:mm:ss' });


		$(document).on("click", "#form-home span.small", function () {
	 		// Cuando hagamos click en SPAN con clase "small" hacemos lo siguiente...
			// $(this) es el elemento actual, osea: #form-home span.small
			// .parent() es el elemento padre, osea, el elemento superior a este.
			if($(this).text() == "Registrar"){
				$(this).parent().parent().find("#register").slideDown();
				$(this).parent().parent().find("#login").slideUp();
			}
			if( $(this).text() == "Ingresar"){
				// Si el texto de este elemento es Ingresar hacemos que
				// Buscamos el elemento padre, el h2, y hacemos lo mismo, y llegamos al section#form-home
				// Ahi buscamos el elemento con ID register y lo ocultamos
				// y con ingresar lo mostramos
				
				$(this).parent().parent().find("#register").slideUp();
				$(this).parent().parent().find("#login").slideDown();		
			}
			$("span.active").addClass("small");
			$("span.active").removeClass("active");
			$(this).removeClass("small");
			$(this).addClass("active");
		})
	 }
	 </script>
	<script type="text/javascript">
tinymce.init({
    selector: "textarea"
 });
</script>
</head>
<body>
	<section id="container">
