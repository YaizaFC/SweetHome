<?php
	require("./vendor/autoload.php");
	require("globals.php");
	use UserAuth\User as User;
	$user = new User($db);
	$titulo = "Editando mi casa rural - SweetHome";
	if(empty($user) || $user->isLogged() == false){
		header('Location: index.php');
		die();
	}
	
	$casa_info = $db->select("casas", array('casa_owner' => $user->getUserID()));
	
	$new = empty($casa_info);
	$errors = [];
	$info = [];
	if(!empty($_POST)){ //Guardando cambios, O insertando casa nueva
		if(empty($_POST['casa_name']) || empty($_POST['casa_desc']) || empty($_POST['casa_ubication'])){
			$errors[] = "Faltan datos. Asegúrate de haber rellenado todo y vuelve a intentarlo.";
		} else {
			
			
			if (!empty($_FILES['casa_img']['tmp_name']) && $_FILES['casa_img']['error'] == UPLOAD_ERR_OK) {
				$path = $_FILES['casa_img']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$name = $user->getRandomKey().".".$ext;
				$upload_check = move_uploaded_file($_FILES['casa_img']['tmp_name'], "img/".$name);
			}
			if(!empty($new) && (empty($upload_check) || $upload_check == false)){
				$errors[] = "Fallo al subir imagen. Casa no guardada.";
			} elseif(!empty($new)){ //Subiendo casa por primera vez
				$result = $db->insert("casas",array("casa_name" => $_POST['casa_name'], "casa_desc" => $_POST['casa_desc'], "casa_img" => "img/".$name, "casa_ubication" => $_POST['casa_ubication'],"casa_owner" => $user->getUserID(), "casa_active" => 1));
			} else { //Actualizando casa
				if(!empty($_FILES['casa_img']['tmp_name'])){
					if(!empty($_FILES['casa_img']['tmp_name']) && $_FILES['casa_img']['error'] != UPLOAD_ERR_OK ){
						$errors[] = "Fallo al intentar subir la imagen. Los cambios no han sido guardados.";
						
					} elseif(!empty($_FILES['casa_img']['tmp_name']) && $upload_check == true) {
						$result = $db->update("casas", array("casa_img" => "img/".$name, "casa_name" => $_POST['casa_name'], "casa_desc" => $_POST['casa_desc'],"casa_ubication" => $_POST['casa_ubication']),  array('casa_id' => $casa_info['casa_id'], 'casa_owner' => $user->getUserID()));
					}
				} else {
					$result = $db->update("casas", array("casa_name" => $_POST['casa_name'], "casa_desc" => $_POST['casa_desc'],"casa_ubication" => $_POST['casa_ubication']),  array('casa_id' => $casa_info['casa_id']));
				}
			}
			//else 
			
			if(!empty($result)){
				if(empty($new)){
					$info[] = "Casa actualizada.";
				} else {
					$info[] = "Casa subida.";
				}

				header('Refresh:1;URL=micasa.php');
			} else {
				$errors[] = "Fallo al intentar insertar casa.";
			}
			
			
			
		};
		
	}
	
	include("./inc/headers.php");
?>
		<?php include("./inc/navbar.php"); 
		if(count($errors) >0){
			makeInfoBox("error",$errors);
		} elseif(count($info) >0){
			makeInfoBox("correct",$info);
		}
		?>
		<main class="container" style="padding-top:20px">
			<form method="POST" enctype="multipart/form-data">
				<div class="row s8 m8 l8 center">
					
					<label for="casa_name">Título de la casa</label>
					<input type="text" id="casa_name" name="casa_name" placeholder="" value="<?php if(empty($new)){ print $casa_info['casa_name']; }; ?>" />
				</div>
				<div class="row center s12 m10 l8">

					<div class="row col s12 m12 l7">
						<img src="<?php if(empty($new)){ print $casa_info['casa_img']; } else {print 'img/no_image.png';}; ?>" class="responsive-img" />

						<br />
						<span class="right"><?php if(empty($new)){ print $casa_info['casa_score']; } else {print 0;}; ?> Puntos</span>
					</div>
					<div class="row col s12 m12 l5 left-align">
					
					 <div class="input-field col s12">
					  <textarea id="casa_desc" name="casa_desc" class="materialize-textarea"><?php if(empty($new)){ print $casa_info['casa_desc']; } ?></textarea>
					  <label for="casa_desc">Descripción de la casa</label>
					</div>
					
					
						<div class="row s12">
						<span id="casa_desc" name="casa_desc"></span>
						</div>
						<div class="row s12">
						
							<div class="file-field input-field col s12">
							  <div class="btn">
								<span><i class="material-icons">file_upload</i></span>
								<input id="casa_img" name="casa_img" type="file" class="<?php if($new){ ?>validate<?php }; ?>" />
							  </div>
							  <div class="file-path-wrapper">
								<input class="file-path validate" type="text" placeholder="Subir imagen..." />
							  </div>
							</div>
							
						</div>
						<div class="row s12" style="padding-top:20px">
							<div class="input-field s12">
								<i class="material-icons prefix">map</i>
								<input id="casa_ubication" name="casa_ubication" type="url" class="validate" placeholder="https://goo.gl/maps/..."  value="<?php if(empty($new)){ print $casa_info['casa_ubication']; }; ?>" />
								<label for="casa_ubication">URL a Google Maps</label>
							</div>
						</div>
					</div>
					<div class="input-field row s9 m6 l3 right">
					  <button class="btn waves-effect waves-light" type="submit" name="action">Guardar cambios
						<i class="material-icons right">save</i>
					  </button>
					</div>
					
				</div>
			</form>
			<?php if($new){ ?>
			<div class="row s12">
				<?php makeInfoBox("warning","Aún no has publicado tu casa."); ?>
			</div>
			<?php };
			
			$preguntas = $db->selectAll("preguntas",array("pregunta_casa" => $casa_info['casa_id']));
			
			if(!empty($preguntas)){ //Hay preguntas que responder y/o eliminar
				foreach($preguntas as $pregunta){ ?>
					<div class="row s12 m12 l12 pregunta">
						<div class="row s12 m6 l3 pregunta_nombre  container">
							<span><?php print $pregunta['pregunta_opcional_nombre']; ?></span>
						</div>
						<div class="row s12 m12 l12 pregunta_texto  container">
							<p><?php print $pregunta['pregunta_texto']; ?>
						</div>
						<div class="row s6 m6 l3 center-align centered center">
							<a href="mailto:<?php print $pregunta['pregunta_opcional_email']; ?>" class="btn waves-effect waves-light">Responder<i class="material-icons right">save</i></a>
							<a href="#" class="btn waves-effect waves-light red" onClick="eliminarPregunta(<?php print $pregunta['pregunta_id']; ?>,this);">Eliminar<i class="material-icons right">delete_forever</i></a>
						</div>
					</div>
				<?php };
				
			}
			
			?>
		</main>
		<?php include ("footer.php"); ?>
	</body>
</html>