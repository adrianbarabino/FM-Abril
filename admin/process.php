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



	function show_message($value)
	{

		$title = "Procesando datos";
		require("./header.php");
				// Segun el valor de la variable value mostramos el mensaje acorde.

				echo '<h1><i class="icon-info-sign icon-large"></i> ';
				switch($value){

				case "logout":
					echo "Has salido satisfactoriamente";
				break;
				case "login_not_exist":
					echo "El email no existe en la base de datos";
				break;
				case "fail_login_pwd":
					echo "Contraseña Incorrecta";
				break;
				case "wrong_mail":
					echo "El email ingresado no es válido";
				break;
				case "login_ok":
					echo "Has ingresado satisfactoriamente";
				break;
				case "duplicated_register":
					echo "Ya hay otro usuario con ese email";
				break;
				case "register_ok":
					echo "Te registraste satisfactoriamente";
				break;
				case "empty_fields":
					echo "No llenaste todos los campos";
				break;
				}
				echo "</h1>";



			?>
				<script>
				function go_home () {
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
				setTimeout(go_home, 2000);
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

						show_message("login_ok");

					}
					else
					{
						// SI la contraseña no coincide con el email del usuario, le decimos que puso mal su Contraseña...
						// WTF? no anda bien...

						show_message("fail_login_pwd");
					}
		}else{
			show_message("empty_fields");
		}

	}

	if($action == "register"){

		if(trim($_POST['email']) != "" && trim($_POST['password']) != "" && trim($_POST['fullname']) != "" && trim($_POST['username']) != ""){

			$email = $user->cleanString($_POST['email']);
			$password = $user->cleanString($_POST['password']);
			$username = $user->cleanString($_POST['username']);
			$fullname = $user->cleanString($_POST['fullname']);

			if (preg_match($regex, $email)) {
				if($user->register($username, $pwd, $email, $fullname, 1, true))
				{

					show_message("register_ok");
				}
			}else{
				show_message("wrong_mail");
			}

		}else{
			show_message("empty_fields");
		}

	}

	if($action == "logout"){


        $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
        setcookie("userLogged", "x", time()-3600, '/', $domain, false);

		show_message('logout');

	}

}else{

	die("Parámetros incorrectos, esta action sera avisada al administrador junto con su IP: ".$_SERVER['REMOTE_ADDR']);
}

?>