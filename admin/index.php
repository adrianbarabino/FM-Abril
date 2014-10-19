<?php


// Cargamos los archivos de configuracion y de conexion.php
require("../data/config.php");
require("../data/connection.php");

require("../classes/User.class.php");

$user = new User;

// ./ se refiere a la carpeta actual, ../ se refiere a la carpeta padre, ../.. dos niveles arriba y asi sucesivamente. y si usamos / solo, refiere a la carpeta raiz

if(isset($_GET['page'])){

	$page = $_GET['page'];
}else{
	$page = "home";
}

$boton_editar = '<i class="icon-edit icon-large"></i>';
$boton_borrar = '<i class="icon-remove icon-large"></i>';
$boton_nuevo = '<i class="icon-plus-sign-alt icon-large"></i> Crear Nuevo';




// Si el usuario ingreso, requerimos cabecera.php y cuerpo.php, en caso contrario mostramos el formulario.
if($user->isLogged()){
	if($user->isAdmin()){
		$title = "Panel de Administración";

		require("header.php");
		require("navigation.php");
		require("content.php");
		require("footer.php");
	}else{
		die("Error...");
	}

}else{
		$title = "Area Restringida";
		require("header.php");
		?>
	<h1 class="saludo_off"><?php echo $config['web_title']; ?> - <i class="icon-group"></i> Miembros</h1>

	<p class="sinlogear">Para poder acceder a esta sección debes ingresar en el sistema, o registrarte.</p>
	

	<section id="form-inicio">
		
		<h2><span class="activo">Ingresar</span> <span class="chico">Registrar</span></h2>
		<form autocomplete="off" action="process.php?action=login" method="POST" id="login">
			<input type="text" name="username" placeholder="Nombre de Usuario">
			<input type="password" name="password" placeholder="Contraseña">
			<input type="submit" value="Ingresar">
		</form>

<!-- 
		<form autocomplete="off" action="process.php?action=register" method="POST" id="register" style="display:none;">
			<input type="text" name="nombre" placeholder="Nombre">
			<input type="text" name="email" placeholder="Email">
			<input type="password" name="password" placeholder="Contraseña">
			<input type="submit" value="Registrar">
		</form>
		 -->
	</section>
	</section>
</body>
</html>

<?php

}

?>

