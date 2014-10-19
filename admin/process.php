<?php

require("../data/config.php");
require("../data/connection.php");

require("../classes/User.class.php");

$user = new User;

$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 

if(isset($_GET['action'])){

	$action = $_GET['action'];
}else{
	die("Parámetros incorrectos, esta action sera avisada al administrador junto con su IP: ".$_SERVER['REMOTE_ADDR']);
}

if($action == "login" || $action == "register" || $action == "logout"){



	function mostrar_mensaje($valor)
	{

		$titulo = "Procesando datos";
		require("./cabecera.php");
				// Segun el valor de la variable VALOR mostramos el mensaje acorde.

				echo '<h1><i class="icon-info-sign icon-large"></i> ';
				switch($valor){

				case "logout":
					echo "Has salido satisfactoriamente";
				break;
				case "ingreso_no_existe":
					echo "El email no existe en la base de datos";
				break;
				case "ingreso_fail_pwd":
					echo "Contraseña Incorrecta";
				break;
				case "email_incorrecto":
					echo "El email ingresado no es válido";
				break;
				case "ingreso_ok":
					echo "Has ingresado satisfactoriamente";
				break;
				case "registro_duplicado":
					echo "Ya hay otro usuario con ese email";
				break;
				case "registro_ok":
					echo "Te registraste satisfactoriamente";
				break;
				case "campos_vacios":
					echo "No llenaste todos los campos";
				break;
				}
				echo "</h1>";



			?>
				<script>
				function ir_home () {
					<?php
					if(isset($_POST['callback'])){
						?>

					location.href = "<?php echo $_POST['callback']; ?>";
						<?php
					}else{
						?>
					location.href = "index.php";
						
						<?php
					}
					?>
				}
				setTimeout(ir_home, 2000);
				</script>
			</section>

		</body>
		</html>
		<?php
	}

	if($action == "login"){


		// Verificamos con TRIM de que las cadenas de EMAIL y PASSWORD no tengan ningun espacio vacio al inicio y al final, y que tampoco se encuentren vacías.


		if(trim($_POST["username"]) != "" && trim($_POST['password']) != "")
		{

			$username = $user->cleanString($_POST['username']);
			$password = $user->cleanString($_POST['password']); 

				if(is_array($user->login($username, $password)))

					{

						mostrar_mensaje("ingreso_ok");

					}
					else
					{
						// SI la contraseña no coincide con el email del usuario, le decimos que puso mal su Contraseña...
						// WTF? no anda bien...

						mostrar_mensaje("ingreso_fail_pwd");
					}
		}else{
			mostrar_mensaje("campos_vacios");
		}

	}

	if($action == "register"){

		if(trim($_POST['email']) != "" && trim($_POST['password']) != "" && trim($_POST['fullname']) != "" && trim($_POST['username']) != ""){

			$email = remover_etiquetas($_POST['email']);
			$password = remover_etiquetas($_POST['password']);
			$username = remover_etiquetas($_POST['username']);
			$fullname = remover_etiquetas($_POST['fullname']);

			if (preg_match($regex, $email)) {
				if(is_array($user->register($username, $pwd, $email, $fullname, 0)))
				{

					mostrar_mensaje("registro_ok");
				}
			}else{
				mostrar_mensaje("email_incorrecto");
			}

		}else{
			mostrar_mensaje("campos_vacios");
		}

	}

	if($action == "logout"){


        $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
        setcookie("userLogged", "x", time()-3600, '/', $domain, false);

		mostrar_mensaje('salir');

	}

}else{

	die("Parámetros incorrectos, esta action sera avisada al administrador junto con su IP: ".$_SERVER['REMOTE_ADDR']);
}

?>