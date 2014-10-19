<?php


require("../data/config.php");
require("../data/connection.php");

require("../classes/User.class.php");

$user = new User;
if($user->isLogged()){
	if($user->isAdmin()){


function subir_imagen($id)
{
	// Incluyo la librería WideImage
	require("./lib/WideImage.php");
	// Cargo la imagen, la redimensiono y la guardo.
	WideImage::load($_FILES["imagen"]["tmp_name"])->resize(600, 600)->saveToFile("../imagenes/$id.jpg");
	WideImage::load($_FILES["imagen"]["tmp_name"])->resize(200, 150)->saveToFile("../imagenes/thumb/$id.jpg");


}
function delete_table($table, $id, $nombre)
{	
				global $mysqli;

				$query_borrar = "delete from $table where id='$id'";

				$mysqli->query($query_borrar);
				echo $nombre . " ha sido borrado exitosamente de la base de datos, seras redireccionado en unos segundos";
};

function create_table($table, $fields)
{
				global $user;

				// Serialize nos sirve para poder convertir un array en una cadena de texto...
				// Unserialize es para decifrar y poder volver esa cadena de texto en un array...

				$fields = unserialize($fields);
				switch ($table) {
					case 'content':
								$nombre      = $fields['nombre'];
								$descripcion = $fields['descripcion'];
								$id_categoria = $fields['id_categoria'];
								$fecha_ingreso   = $fields['fecha_ingreso'];
								$disponibles     = $fields['disponibles'];
								$precio    = $fields['precio'];

								$create_query = "insert into $table (nombre,id_categoria,fecha_ingreso,descripcion,disponibles,precio) VALUES ('$nombre','$id_categoria','$fecha_ingreso','$descripcion','$disponibles','$precio')";
								
					break;
					case 'compras':
								$id_usuario      = $fields['id_usuario'];
								$descripcion = $fields['descripcion'];
								$id_content = $fields['id_content'];
								$tipo_pago   = $fields['tipo_pago'];
								$id_estado     = $fields['id_estado'];
								$fecha    = $fields['fecha'];

								$create_query = "insert into $table (id_usuario,tipo_pago,fecha,descripcion,id_content,id_estado) VALUES ('$id_usuario','$tipo_pago','$fecha','$descripcion','$id_content','$id_estado')";
								
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
	global $user;

				// Serialize nos sirve para poder convertir un array en una cadena de texto...
				// Unserialize es para decifrar y poder volver esa cadena de texto en un array...

				$fields = unserialize($fields);
				switch ($table) {
					case 'content':
								$nombre      = $fields['nombre'];
								$descripcion = $fields['descripcion'];
								$id_categoria = $fields['id_categoria'];
								$fecha_ingreso   = $fields['fecha_ingreso'];
								$disponibles     = $fields['disponibles'];
								$precio    = $fields['precio'];

								$update_query = "update $table set nombre='$nombre',descripcion='$descripcion',id_categoria='$id_categoria',fecha_ingreso='$fecha_ingreso',disponibles='$disponibles',precio='$precio' WHERE id = '$id'";

								
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
									print_r($fullname);
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
	subir_imagen($id);
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
	subir_imagen($id);
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

$nombre = $_REQUEST['nombre'];

if(!isset($nombre)){
	"Elemento";
}
delete_table($table, $id, $nombre);
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