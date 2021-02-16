<?php
	require("./vendor/autoload.php");
	require("globals.php");
	use UserAuth\User as User;
	$user = new User($db);
	$casa_id = filter_var ( $_GET['id'], FILTER_SANITIZE_NUMBER_INT);
	$casa_info = $db->select("casas", array('casa_id' => $casa_id));

	$titulo = empty($casa_info) ? $casa_info['casa_name'] : "Error - SweetHome";
	
	$errors = array();
	$info = array();
	
	if(!empty($casa_info)){
	$casa_votado = $db->select("votos",array("user_id" => $user->getUserID(), "casa_id" => $casa_id),array("votos"))['votos'];
	
		function selectVoted($score){
			global $casa_votado;
			if(!empty($casa_votado)){
				if($casa_votado == $score){
					print "green";
				} else {
					print "blue";
				}
			}
		}
		
		if(!empty($_POST) && !empty($_POST['pregunta'])){
			
			$opt_name = filter_var($_POST['opt_nombre'],FILTER_SANITIZE_STRING);
			$opt_email = filter_var($_POST['opt_email'],FILTER_SANITIZE_EMAIL);
			$pregunta = filter_var($_POST['pregunta'],FILTER_SANITIZE_STRING);
			if(empty($opt_name)){
				$opt_name = "Usuario #".$user->getUserID();
				$opt_email = $user->getUserEmail();
			} //Vale, no son opcionales si siempre se meten, pero para no liarnos con mezclas de tablas...
			$resultado = $db->insert("preguntas",array("pregunta_uid" => $user->getUserID(), "pregunta_casa" => $casa_info['casa_id'], "pregunta_texto" => $pregunta,"pregunta_opcional_nombre" => $opt_name, "pregunta_opcional_email" => $opt_email));

			if(!empty($resultado)){
				$info[] = "Pregunta guardada. El dueño le responderá via email próximamente.";
			} else {
				$errors[] = "Fallo al insertar pregunta.";
			}
		};
		
	};
	include("./inc/headers.php");
?>
		<?php include("./inc/navbar.php"); ?>
		<main class="container">
			<?php if(empty($casa_info)){
				makeInfoBox("error","<i class=\"material-icons\" style=\"font-size:30pt\">warning</i><br />La casa indicada no existe. Puede que haya sido borrada por el dueño o por la administración del sitio.");
			} else { 
			
			if(!empty($_POST)){
				if(count($errors) >0){
					makeInfoBox("error",$errors);
				} elseif(count($info) >0){
					makeInfoBox("correct",$info);
				}
			}
			?>
			
			<div class="row center s12 m10 l8">
				<div class="row s12">
					<h3 id="casa_name" name="casa_name"><?php print $casa_info['casa_name']; ?></h3>
				</div>
				<div class="row col s12 m12 l7">
					<img src="<?php print $casa_info['casa_img']; ?>" alt="Image" class="responsive-img" />
					<br />
					<div class="row col s3 m3 l3 right">
						<span id="puntos" name="puntos"><?php print $casa_info['casa_score']; ?> Puntos</span>
					</div>
					<?php if(!empty($user) && $user->isLogged() && $user->getOwnerHomeID() != $casa_id){ ?>
					
					<div class="row col s9 m9 l9 left">
						<span>Puntuar:
							<a class="waves-effect waves-light btn-small <?php selectVoted(1); ?> votos" href="#" onclick="submitScore(<?php print $casa_id; ?>,1);">1</a>
							<a class="waves-effect waves-light btn-small <?php selectVoted(2); ?> votos" href="#" onclick="submitScore(<?php print $casa_id; ?>,2);">2</a>
							<a class="waves-effect waves-light btn-small <?php selectVoted(3); ?> votos" href="#" onclick="submitScore(<?php print $casa_id; ?>,3);">3</a>
							<a class="waves-effect waves-light btn-small <?php selectVoted(4); ?> votos" href="#" onclick="submitScore(<?php print $casa_id; ?>,4);">4</a>
							<a class="waves-effect waves-light btn-small <?php selectVoted(5); ?> votos" href="#" onclick="submitScore(<?php print $casa_id; ?>,5);">5</a>
						</span>
					</div>
					<?php }; ?>
				</div>
				<div class="row col s12 m12 l5">
					<span class="left" id="casa_desc" name="casa_desc"><?php print $casa_info['casa_desc']; ?></span>
					<br />
					  <a class="waves-effect waves-teal btn-flat left" href="<?php print htmlentities($casa_info['casa_ubication']); ?>" id="casa_ubication" name="casa_ubication"><i class="material-icons" style="font-size:30pt">map</i></a>
				</div>
			</div>
				<?php if(!empty($user) && $user->isLogged() && $user->getOwnerHomeID() != $casa_id){ ?>
					<hr />
					<div class="row s10 m10 l10">
						<h3>Enviar preguntas:</h3>
						
						<form id="formularioPreguntas" method="POST">
							<div class="input-field">
								<label for="opt_nombre">Nombre</label>
								<input id="opt_nombre" name="opt_nombre" type="text" maxlength="90" />
							</div>
							<div class="input-field">
								<label for="opt_email">Email</label>
								<input id="opt_email" name="opt_email" type="email" maxlength="200" />
							</div>
							<div class="input-field">
								<label for="pregunta">Pregunta al autor</label>
								<textarea id="pregunta" name="pregunta" class="materialize-textarea validate" required></textarea>
							</div>
							<div class="input-field">
							  <button class="btn waves-effect waves-light" type="submit" name="action">Enviar
								<i class="material-icons right">send</i>
							  </button>
							</div>
						</form>
					</div>
				<?php }; ?>
			<?php }; ?>
		</main>
		<?php include ("footer.php"); ?>
	</body>
</html>