<?php
	require("./vendor/autoload.php");
	require("globals.php");
	use UserAuth\User as User;
	$user = new User($db);
	
	if(!empty($user) && $user->isLogged()){
		$user->logout($user->getSessionHash());
		header('Location: index.php'); 
		exit;
	}