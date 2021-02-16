<?php
require("./vendor/autoload.php");
require("globals.php");
use UserAuth\User as User;
$user = new User($db);
if(!empty($_POST)){

	if(empty($user) || !$user->isLogged()){die();};
	$pregunta = (int) filter_var( $_POST['pregunta_id'], FILTER_SANITIZE_NUMBER_INT);
	$uid = $user->getUserID();
	$result = $db->delete("preguntas",array("pregunta_id" => $pregunta, "pregunta_casa" => $user->getOwnerHomeID()));
	
	print (string) $result;
}