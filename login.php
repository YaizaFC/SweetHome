<?php
	require("./vendor/autoload.php");
	require("globals.php");
	use UserAuth\User as User;
	$title = "Iniciar sesión";
	$user = new User($db);
	
	$errors = [];
	$info = [];
	if(!empty($_POST)){
		if(empty($_POST['email']) | empty($_POST['password'])){
			$errors[] = "Falta alguno de los datos!";
		} else {
			$return = $user->login($_POST['email'],$_POST['password'],!empty($_POST['remember']));
			if(!empty($return) && !empty($return['message'])){
				 if($return['error'] == true){
					$errors[] = $return['message'];
				} else {
					header('Refresh:2;URL=index.php');
					$info[] = $return['message'];
				};
			};
		}
	};
	
	if(!empty($user) && $user->isLogged()){ header('Location: index.php'); exit;}
	include("./inc/headers.php");
	

?>
		<?php include("./inc/navbar.php"); ?>
		<main class="container">
		<?php
		if(!empty($_POST)){
			if(count($errors) >0){
				makeInfoBox("error",$errors);
			} elseif(count($info) >0){
				makeInfoBox("correct",$info);
			}
		}
		?>
			<h2>Iniciar sesión:</h2>
			<h6>(¿No tienes cuenta? <a href="register.php">Registrate aquí</a>)</h6>
			<div class="row center s12">
				<form action="login.php" method="post" class="col s12">
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
					  <input placeholder="Contraseña" id="password" name="password" type="password" class="validate" />
					  <label for="email">Contraseña</label>
					</div>
				  </div>
				  <div class="row left">
					<div class="input-field col s6 m12 l12">
						<p>
						  <label>
							<input type="checkbox" id="remember" name="remember" />
							<span style="color:black !important">Recordarme</span>
						  </label>
						</p>
					</div>
				  </div>
				  <div class="row center">
					<div class="input-field col s6 m12 l12">
					  <button class="btn waves-effect waves-light" type="submit" name="action">Iniciar sesión
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