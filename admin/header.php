<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title><?php echo $title; ?></title>
	<!-- Añadimos el TinyMCE, el editor WYSIWYG -->
	<script src="./js/tinymce/tinymce.min.js"></script>
	<!-- Incluimos jQuery y jQueryUI -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<!-- Cargamos nuestro DateTime Picker -->
	<script src="./js/plupload/plupload.full.min.js"></script>
	<script src="./js/plupload/jquery.ui.plupload/jquery.ui.plupload.js"></script>
	<script src="./js/jquery.datetimepicker.js"></script>
	<!-- Cargamos la traduccion -->
	<script src="./js/jquery.datepicker.spanish.js"></script>
	<link rel="stylesheet" href="./css/style.css">
	<link rel="stylesheet" href="./js/plupload/jquery.ui.plupload/css/jquery.ui.plupload.css">
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

	 	$('input[name="fecha"], input[name="date"]').datetimepicker({ dateFormat: 'yy-mm-dd', timeFormat: 'hh:mm:ss' });


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
	tinymce.PluginManager.add('toolbarplugin', function(editor, url) {
    editor.addButton('toolbarplugin',
        {title       : 'my plugin button',
         image       : url + '/img/toolbarplugin.png',
         onclick     : function() { alert('Clicked!');}});
});

tinymce.init({
    selector: "textarea",
    theme: "modern",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor youtube"
    ],
    pagebreak_separator: "[readmore]",
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
    toolbar2: "  link image | media youtube | forecolor backcolor emoticons | pagebreak",
    image_advtab: true

 });
</script>
</head>
<body>
	<section id="container">
