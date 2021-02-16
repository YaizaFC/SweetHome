<?php
	require("./vendor/autoload.php");
	require("globals.php");
	use UserAuth\User as User;
	$user = new User($db);
	if(!empty($user) && $user->isLogged()){ header('Location: index.php'); exit;}
	$title = "Registro";
	
	$errors = [];
	$info = [];
	if(!$db){die();}
	if(!empty($_POST)){
		if(empty($_POST['email']) | empty($_POST['password']) | empty($_POST['password2'])){
			$errors[] = "Falta alguno de los datos!";
		} else {
			
			$params = array();
			if(!empty($_POST['siPropietario'])){
				$params['is_owner'] = 1;
			}
			$return = $user->register($_POST['email'],$_POST['password'],$_POST['password2'],$params);
			if(!empty($return) && !empty($return['message'])){
				 if($return['error'] == true){ //failure when registering
					$errors[] = $return['message'];
				} else { //register has been successful
					$info[] = $return['message'];
					$user->login($_POST['email'],$_POST['password']);
					header('Refresh:3;URL=index.php');
				};
			};
		}
		
	}
	
	
	
	include("./inc/headers.php");
?>
		<?php include("./inc/navbar.php"); ?>
		<main class="container">
		<?php
		if(count($errors) >0){
			makeInfoBox("error",$errors);
		} elseif(count($info) >0){
			makeInfoBox("correct",$info);
		}
		?>
			<h2>Registrar nuevo usuario:</h2>
			<h6>(¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a>)</h6>
			<div class="row center s12">
				<form action="register.php" method="post" class="col s12">
				  <div class="row">
					<div class="input-field col s6 m12 l12">
					  <i class="material-icons prefix">email</i>
					  <input placeholder="Email" id="email" name="email" type="email" class="validate" />
					  <label for="email">Email</label>
					</div>
				  </div>
				  <div class="row center">
					<div class="input-field col s6 m12 l12">
					  <i class="material-icons prefix">lock</i>
					  <input placeholder="Contraseña" id="password" name="password" type="password" class="validate" onKeyUp="checkPassword(this);" />
					  <label for="email">Contraseña</label>
					</div>
				  </div>
				  <div class="row center">
					<div class="input-field col s6 m12 l12">
					  <i class="material-icons prefix">lock</i>
					  <input placeholder="Repetir contraseña" id="password2" name="password2" type="password" class="validate" onKeyUp="checkPasswordMatch(this);" />
					  <label for="email">Repetir contraseña</label>
					</div>
				  </div>
				  <div class="row left">
					<div class="input-field col s6 m12 l12">
						<p>
						  <label>
							<input type="checkbox" id="siPropietario" name="siPropietario" />
							<span style="color:black !important">Soy propietario de una casa</span>
						  </label>
						</p>
					</div>
				  </div>
				  <div class="row center">
					<div class="input-field col s6 m12 l12">
					  <button class="btn waves-effect waves-light" type="submit" name="action">Registrar
						<i class="material-icons right">send</i>
					  </button>
					</div>
				  </div>
				</form>
			</div>
		</main>
		<?php include ("footer.php"); ?>
	</body>
</html>