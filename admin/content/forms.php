<center><?php

if(isset($_GET['id'])){
	$id = $_GET['id'];
}

if(isset($_GET['action'])){
	$action = $_GET['action'];
}

if(isset($_GET['table'])){
	$table = $_GET['table'];
}

if(!isset($id)){
	$id = "0";
}
if(!isset($action)){
	die("Parametros incorrectos");
}

if(!isset($table)){
	die("Parametros incorrectos");
}else{

	switch($table){

		case "content":
		if($content->isExist($id)){
			if($result = $content->getContent($id)){
				$id_cat = $result['id_cat'];
				$id_author = $result['id_author'];
				$title = $result['title'];
				$content = $result['raw_content'];
				$date = $result['date'];
				$tags = $result['tags'];
				$slug = $result['slug'];
			}


		}else{
			$id_cat = '';
			$id_author = '';
			$title = '';
			$content = '';
			$date = date("Y-m-d H:i:s");
			$tags = '';
			$slug = '';
		}

		break;

		case "users":
		if($user->isExist($id)){
			if($result = $user->getUserData($id)){
				$username = $result['username'];
				$fullname = $result['fullname'];
				$email = $result['email'];
				$rank = $result['rank'];
				// en Password vamos a poner NO edit, eso es porque no podemos leer la contraseña del usuario
				// Entonces si no editamos este campo, no se va a cambiar la contraseña del usuario.

				$password = "no-edit";
			}


		}else{
			$username = '';
			$fullname = '';
			$email = '';
			$rank = '';
			$password = '';
		}

		break;
		case "compras":
		$consulta = "SELECT * FROM compras WHERE id = ".$id." LIMIT 0,1";
		$consulta_db = $mysqli->query($consulta);

		if($resultado = $consulta_db->fetch_assoc()){
		
		$id_usuario = $resultado['id_usuario'];
		$id_item = $resultado['id_item'];
		$tipo_pago = $resultado['tipo_pago'];
		$id_estado = $resultado['id_estado'];
		$fecha = $resultado['fecha'];
		$descripcion = $resultado['descripcion'];


		}else{

		$id_usuario = '';
		$id_item = '';
		$tipo_pago = '';
		$id_estado = '';
		$fecha = date("Y-m-d H:i:s");
		$descripcion = '';


		}

		break;
	}


}




	switch($table){

		case "content":
		?>
		
		<form enctype="multipart/form-data" action="./actions.php" id="formulario" method="GET" class="action">
			<input type="file" name="image" id="image">
			<?php if($action == "edit"){ ?>
			<input name="id" id="id" type="hidden" value="<?php echo $id; ?>">
			<?php } ?>
			<input name="action" id="action" type="hidden" value="<?php echo $action; ?>">
			<input name="table" id="table" type="hidden" value="<?php echo $table; ?>">
			<br><label for="title">Titulo:</label>
			<input name="title" id="title" type="text" value="<?php echo $title; ?>">
			<br><label for="slug">Slug:</label>
			<input name="slug" id="slug" type="text" value="<?php echo $slug; ?>">			
			<br><label for="tags">Etiquetas:</label>
			<input name="tags" id="tags" type="text" value="<?php echo $tags; ?>">
			<br><label for="content">Contenido:</label>
			<textarea name="content" id="content" type="text"><?php echo $content; ?></textarea>
			<br><label for="category">Categoría:</label>
			<select name="id_cat" id="category">
			<?php


if($result = $category->getAll()){
	foreach ($result as $key => $item) {
		?>

    <option <?php if($id_cat == $item['id']){?> selected="selected" <?php }; ?> value="<?php echo $item['id'];?>"><?php echo $item['name'];?></option>
<?php
}
}
?>

			</select>
			<br><label for="date">Fecha:</label>
			<input name="date" id="date" type="text" value="<?php echo $date; ?>">
			<input name="enviar" type="submit" value="enviar">
			<input name="limpiar" type="button" value="limpiar">
		</form>

		<?php
		
		break;
	case "categories":
		?>
		
		<form action="./actions.php" id="formulario" method="POST" class="action">
			<?php if($action == "edit"){ ?>
			<input name="id" id="id" type="hidden" value="<?php echo $id; ?>">
			<?php } ?>
			<input name="action" id="action" type="hidden" value="<?php echo $action; ?>">
			<input name="table" id="table" type="hidden" value="<?php echo $table; ?>">
			<br><label for="nombre">Nombre:</label>
			<input name="nombre" id="nombre" type="text" value="<?php echo $nombre; ?>">
			<input name="enviar" type="submit" value="enviar">
			<input name="limpiar" type="button" value="limpiar">
		</form>

		<?php
		
		break;
	case "estados":
		?>
		
		<form action="./actions.php" id="formulario" method="POST" class="action">
			<?php if($action == "edit"){ ?>
			<input name="id" id="id" type="hidden" value="<?php echo $id; ?>">
			<?php } ?>
			<input name="action" id="action" type="hidden" value="<?php echo $action; ?>">
			<input name="table" id="table" type="hidden" value="<?php echo $table; ?>">
			<br><label for="nombre">Nombre:</label>
			<input name="nombre" id="nombre" type="text" value="<?php echo $nombre; ?>">
			<input name="enviar" type="submit" value="enviar">
			<input name="limpiar" type="button" value="limpiar">
		</form>

		<?php
		
		break;

	case "t_pagos":
		?>
		
		<form action="./actions.php" id="formulario" method="POST" class="action">
			<?php if($action == "edit"){ ?>
			<input name="id" id="id" type="hidden" value="<?php echo $id; ?>">
			<?php } ?>
			<input name="action" id="action" type="hidden" value="<?php echo $action; ?>">
			<input name="table" id="table" type="hidden" value="<?php echo $table; ?>">
			<br><label for="nombre">Nombre:</label>
			<input name="nombre" id="nombre" type="text" value="<?php echo $nombre; ?>">
			<input name="enviar" type="submit" value="enviar">
			<input name="limpiar" type="button" value="limpiar">
		</form>

		<?php
		
		break;

	case "users":
		?>
		
		<form action="./actions.php" id="formulario" method="GET" class="action">
			<?php if($action == "edit"){ ?>
			<input name="id" id="id" type="hidden" value="<?php echo $id; ?>">
			<?php } ?>
			<input name="action" id="action" type="hidden" value="<?php echo $action; ?>">
			<input name="table" id="table" type="hidden" value="<?php echo $table; ?>">
			<br><label for="username">Nombre de usuario:</label>
			<input name="username" id="username" type="text" value="<?php echo $username; ?>">
			<br><label for="email">Email:</label>
			<input name="email" id="email" type="text" value="<?php echo $email; ?>">
			<br><label for="fullname">Nombre Completo:</label>
			<input name="fullname" id="fullname" type="text" value="<?php echo $fullname; ?>">
			<br><label for="rank">Rango:</label>
			<select name="rank" id="rank">
				<option <?php if($rank == "1"){?>selected<?php };?>  value="1">Usuario Comun</option>
				<option <?php if($rank == "2"){?>selected<?php };?> value="2">Administrador</option>
			</select>
			<br><label for="password">Password:</label>
			<input name="password" id="password" type="text" value="<?php echo $password; ?>">
			<input name="enviar" type="submit" value="enviar">
			<input name="limpiar" type="button" value="limpiar">
		</form>

		<?php
		
		break;

	case "compras":
		?>
		
		<form action="./actions.php" id="formulario" method="POST" class="action">
			<?php if($action == "edit"){ ?>
			<input name="id" id="id" type="hidden" value="<?php echo $id; ?>">
			<?php } ?>
			<input name="action" id="action" type="hidden" value="<?php echo $action; ?>">
			<input name="table" id="table" type="hidden" value="<?php echo $table; ?>">

			<br><label for="descripcion">Descripcion:</label>
			<textarea name="descripcion" id="descripcion" type="text"><?php echo $descripcion; ?></textarea>
			<br><label for="usuario">users:</label>
			<select name="id_usuario" id="usuario">
			<?php
	$consulta_users = "SELECT * FROM users ORDER BY id DESC";


if($resultado_users = $mysqli->query($consulta_users)){
	while ($usuario = $resultado_users->fetch_array()) {
		?>

    <option <?php if($id_usuario == $usuario['id']){?> selected="selected" <?php }; ?> value="<?php echo $usuario['id'];?>"><?php echo $usuario['nombre'];?></option>
<?php
}
}
?>

			</select>
			<br><label for="id_item">Item:</label>
			<select name="id_item" id="item">
			<?php
	$consulta_items = "SELECT * FROM item ORDER BY id DESC";


if($resultado_items = $mysqli->query($consulta_items)){
	while ($item = $resultado_items->fetch_array()) {
		?>

    <option <?php if($id_item == $item['id']){?> selected="selected" <?php }; ?> value="<?php echo $item['id'];?>"><?php echo $item['nombre'];?></option>
<?php
}
}
?>

			</select>
			<br><label for="id_estado">Estado:</label>
			<select name="id_estado" id="estado">
			<?php
	$consulta_estados = "SELECT * FROM estados ORDER BY id DESC";


if($resultado_estados = $mysqli->query($consulta_estados)){
	while ($estado = $resultado_estados->fetch_array()) {
		?>

    <option <?php if($id_estado == $estado['id']){?> selected="selected" <?php }; ?> value="<?php echo $estado['id'];?>"><?php echo $estado['nombre'];?></option>
<?php
}
}
?>

			</select>
			<br><label for="tipo_pago">Tipo de Pago:</label>
			<select name="tipo_pago" id="tipo_pago">
			<?php
	$consulta_tipo_pagos = "SELECT * FROM t_pagos ORDER BY id DESC";


if($resultado_tipo_pagos = $mysqli->query($consulta_tipo_pagos)){
	while ($tipo_pago = $resultado_tipo_pagos->fetch_array()) {
		?>

    <option <?php if($tipo_pago == $tipo_pago['id']){?> selected="selected" <?php }; ?> value="<?php echo $tipo_pago['id'];?>"><?php echo $tipo_pago['nombre'];?></option>
<?php
}
}
?>

			</select>
			<br><label for="fecha">Fecha:</label>
			<input name="fecha" id="fecha" type="text"value="<?php echo $fecha; ?>">
			<input name="enviar" type="submit" value="enviar">
			<input name="limpiar" type="button" value="limpiar">
		</form>

		<?php
		
		break;


	}



	




?>
</center>