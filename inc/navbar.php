<nav>
			<div class="nav-wrapper">
			  <a href="index.php" class="brand-logo"><img src="img/logo.png" alt="Logo" /></a>
			  <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
			  <ul class="right hide-on-med-and-down">
				<li><a href="ranking.php">Ranking</a></li>
				<?php if(!empty($user) && $user->isLogged() && $user->isOwner()){ ?><li><a href="micasa.php">Mi casa</a></li><?php }; ?>
				<?php if(empty($user) || !$user->isLogged()){ ?>
				<li><a href="login.php">Iniciar sesión</a></li>
				<li><a href="register.php">Registro</a></li>
				<?php }; 
				if(!empty($user) && $user->isLogged()){ ?> 
				<li><a href="logout.php">Cerrar sesión</a></li>
				<?php }; ?>
			  </ul>
			</div>
		</nav>
		<ul class="sidenav" id="mobile-demo">
			<li><a href="ranking.php">Ranking</a></li>
				<?php if(!empty($user) && $user->isLogged() && $user->isOwner()){ ?><li><a href="micasa.php">Mi casa</a></li><?php };
				if(!empty($user) && $user->isLogged()){ ?> 
				<li><a href="logout.php">Cerrar sesión</a></li>
				<?php } else { ?>
				<li><a href="login.php">Iniciar sesión</a></li>
				<li><a href="register.php">Registro</a></li>
				<?php }; ?>
				
		</ul>