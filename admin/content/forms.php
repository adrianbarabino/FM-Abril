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
			$id_author = $user->getCurrentUser();
			$title = '';
			$content = '';
			$date = date("Y-m-d H:i:s");
			$tags = '';
			$slug = '';
		}

		break;
		case "categories":
		if($category->isExist($id)){
			if($result = $category->getData($id)){
				$name = $result['name'];
				$description = $result['description'];
				$slug = $result['slug'];
			}


		}else{
			$name = '';
			$description = '';
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
			<input name="id_author" id="id_author" type="hidden" value="<?php echo $id_author ?>">
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
			<br><label for="name">Nombre:</label>
			<input name="name" id="name" type="text" value="<?php echo $name; ?>">
			<br><label for="description">Descripcion:</label>
			<textarea name="description" id="description"><?php echo $description; ?></textarea>
			<br><label for="slug">Slug:</label>
			<input name="slug" id="slug" type="text" value="<?php echo $slug; ?>">	
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



	}



	




?>
</center>