<?php


// Cargamos los archivos de configuracion y de conexion.php
require("../data/config.php");
require("../data/connection.php");

require("../classes/User.class.php");

$user = new User;

require("../classes/Content.class.php");

$content = new Content;

require("../classes/Category.class.php");

$category = new Category;

require("../classes/Slider.class.php");

$slider = new Slider;

// ./ se refiere a la carpeta actual, ../ se refiere a la carpeta padre, ../.. dos niveles arriba y asi sucesivamente. y si usamos / solo, refiere a la carpeta raiz

if(isset($_GET['page'])){

	$page = $_GET['page'];
}else{
	$page = "home";
}

$edit_button = '<i class="icon-edit icon-large"></i>';
$delete_button = '<i class="icon-remove icon-large"></i>';
$new_button = '<i class="icon-plus-sign-alt icon-large"></i> Crear Nuevo';




// Si el usuario ingreso, requerimos cabecera.php y cuerpo.php, en caso contrario mostramos el formulario.
if($user->isLogged()){
	if(!$user->isAdmin()){
		$page = "guest";
	}
		$title = "Panel de Administración";

		require("header.php");
		require("navigation.php");
		require("content.php");
		require("footer.php");

}else{
		$title = "Area Restringida";
		require("header.php");
		?>
	<h1 class="welcome_guest"><?php echo $config['web_title']; ?> - <i class="icon-group"></i> Miembros</h1>

	<p class="guest">Para poder acceder a esta sección debes ingresar en el sistema.</p>
	

	<section id="form-home">
		
		<h2><span class="active">Ingresar</span>
		<?php

		if($config['register_enabled'])
		{

?> <span class="small">Registrar</span>
<?php 
		} 
?>
</h2>
		<form autocomplete="off" action="process.php?action=login" method="POST" id="login">
			<input type="text" name="username" placeholder="Nombre de Usuario">
			<input type="password" name="password" placeholder="Contraseña">
			<input type="submit" value="Ingresar">
		</form>
<?php

		if($config['register_enabled'])
		{

?>

		<form autocomplete="off" action="process.php?action=register" method="POST" id="register" style="display:none;">
			<input type="text" name="username" placeholder="Nombre de Usuario">
			<input type="text" name="email" placeholder="Email">
			<input type="text" name="fullname" placeholder="Nombre Completo">
			<input type="password" name="password" placeholder="Contraseña">
			<input type="submit" value="Registrar">
		</form>
<?php 
		} 
?>
	</section>
	</section>
</body>
</html>

<?php

}

?>

