<?php
	require("./vendor/autoload.php");
	require("globals.php");
	use UserAuth\User as User;
	$user = new User($db);
	$titulo = "Página principal";
	include("./inc/headers.php");
	
	$casas = $db->selectAll("casas",array(),'*',array("casa_id" =>"DESC"));
?>
		<?php include("./inc/navbar.php"); ?>
		<main class="container">
			<?php
				if(empty($casas)){
					print "<h1>Parece que no hay ninguna casa por aquí...</h1><h3>¡Promociona nuestra web!";
				} else { ?>
					<div class="row s12">
					
					<?php foreach($casas as $casa){
						makeCard($casa['casa_id'],$casa['casa_name'],$casa['casa_img'],$casa['casa_ubication'],$casa['casa_score']);
					} ?>
					</div>
				<?php }; ?>
		</main>
		<?php include ("footer.php"); ?>
	</body>
</html>