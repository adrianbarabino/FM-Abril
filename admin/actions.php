<?php


require("../data/config.php");
require("../data/connection.php");

require("../classes/User.class.php");

$user = new User;


require("../classes/Content.class.php");

$content = new Content;


if($user->isLogged()){
	if($user->isAdmin()){


function upload_image($id)
{
	// Incluyo la librería WideImage
	require("./lib/WideImage.php");
	// Cargo la imagen, la redimensiono y la guardo.
	// WideImage::load($_FILES["image"]["tmp_name"])->resize(600, 600)->saveToFile("../uploads/image/posts/$id.jpg");
	// WideImage::load($_FILES["image"]["tmp_name"])->resize(200, 150)->saveToFile("../uploads/image/posts/thumb/$id.jpg");


}
function delete_table($table, $id, $name)
{	
				global $user;

				switch ($table) {
					case 'users':

						$user->remove($id);
					break;
				}

				echo $name . " ha sido borrado exitosamente de la base de datos, seras redireccionado en unos segundos";
};

function create_table($table, $fields)
{
				global $user;
				global $content;

				// Serialize nos sirve para poder convertir un array en una cadena de texto...
				// Unserialize es para decifrar y poder volver esa cadena de texto en un array...

				$fields = unserialize($fields);
				switch ($table) {
					case 'content':
								$title      = $fields['title'];
								$content = $fields['content'];
								$id_cat = $fields['id_cat'];
								$date   = $fields['date'];
								$id_author     = $fields['id_author'];
								$slug    = $fields['slug'];
								$tags    = $fields['tags'];

								return $content->newContent($id_cat, $id_author, $title, $content, $tags, $slug, $date);
								
					break;
					case 'users':
								$username      = $fields['username'];
								$email = $fields['email'];
								$fullname = $fields['fullname'];
								$rank = $fields['rank'];
								$password      = $fields['password'];
								return $user->register($username, $password, $email, $fullname, $rank);
								
					break;
					case 'categorias':
								$nombre      = $fields['nombre'];
								$create_query = "insert into $table (nombre) VALUES ('$nombre')";
					break;
					case 't_pagos':
								$nombre      = $fields['nombre'];
								$create_query = "insert into $table (nombre) VALUES ('$nombre')";
					break;
					case 'estados':
								$nombre      = $fields['nombre'];
								$create_query = "insert into $table (nombre) VALUES ('$nombre')";
					break;

				}
				// $mysqli->query($create_query);
}
function edit_table($table, $id, $fields)
{
	global $user, $content;

				// Serialize nos sirve para poder convertir un array en una cadena de texto...
				// Unserialize es para decifrar y poder volver esa cadena de texto en un array...

				$fields = unserialize($fields);
				switch ($table) {
					case 'content':
								$title      = $fields['title'];
								$content2 = $fields['content'];
								$id_cat = $fields['id_cat'];
								$date   = $fields['date'];
								$id_author     = $fields['id_author'];
								$slug    = $fields['slug'];
								$tags    = $fields['tags'];

								return $content->editContent($id, $id_cat, $id_author, $title, $content2, $tags, $slug, $date);
								
					break;
					case 'users':
								$username = $fields['username'];
								$email = $fields['email'];
								$fullname = $fields['fullname'];
								$rank = $fields['rank'];
								$password = $fields['password'];
								$last_ip = $fields['last_ip'];

								if($password == "no-edit"){
									$user->editUser($id, $username, $email, $fullname, $rank);
								}else{
									$user->editUser($id, $username, $email, $fullname, $rank, NULL, $password);
									
								}

					break;
					case 'categorias':
								$nombre      = $fields['nombre'];
								$update_query = "update $table set nombre='$nombre' WHERE id = '$id'";
					break;

				}
								// $db->query($update_query);

}




$action = $_REQUEST['action'];
$table = $_REQUEST['table'];

if ($_REQUEST['action'] == 'edit') {



$id = $_REQUEST['id'];

if($_FILES){
	upload_image($id);
}

edit_table($table, $id, serialize($_REQUEST));

?>
<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Editando...</title>
	<!-- Redireccionamos a la page de edit -->
<meta http-equiv="Refresh" content="1;url=index.php?page=forms&table=<?php
echo $table;
?>&action=edit&id=<?php
				echo $id;
?>">
</head>
<body>
	Serás redireccionado en los próximos segundos.
</body>
</html>
<?php



}elseif($_REQUEST['action'] == 'create'){


$id = create_table($table, serialize($_REQUEST));

if($_FILES){
	upload_image($id);
}
?>
<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Editando...</title>
	<!-- Redireccionamos a la page de edit -->
<meta http-equiv="Refresh" content="1;url=index.php?page=forms&table=<?php
echo $table;
?>&action=edit&id=<?php
				echo $id;
?>">
</head>
<body>
	Serás redireccionado en los próximos segundos.
</body>
</html>
<?php



}elseif($_REQUEST['action'] == 'delete'){
$id = $_REQUEST['id'];

$name = $_REQUEST['name'];

if(!isset($name)){
	"Elemento";
}
delete_table($table, $id, $name);
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

<meta http-equiv="Refresh" content="1;url=index.php?page=<?php
echo $table;
?>">
</head>
<?php
} 

}else{
	die("Error...");
}
}
?>