<?php
require("./vendor/autoload.php");
require("globals.php");
use UserAuth\User as User;
$user = new User($db);
if(!empty($_POST)){

	if(empty($user) || !$user->isLogged()){die();};
	$casa_id = (int) filter_var( $_POST['id'], FILTER_SANITIZE_NUMBER_INT);
	$votos = (int) filter_var($_POST['votos'], FILTER_SANITIZE_NUMBER_INT);
	if(empty($votos) || $votos < 1 || $votos > 5){die();}; //En ambos casos el usuario no está enviando información adecuada. Desechar.
	$uid = $user->getUserID();
	$sql = "CALL del_vote(".$uid.",".$casa_id."); CALL add_vote(".$uid.",".$casa_id.",".$votos.")";
	$db->query($sql);
}
if(!empty($_POST['id'])){
	$casa_id = (int) filter_var ( $_POST['id'], FILTER_SANITIZE_NUMBER_INT);
} elseif(!empty($_GET['id'])){
	$casa_id = (int) filter_var ( $_GET['id'], FILTER_SANITIZE_NUMBER_INT);
} else {
	die(); //No hay ningún ID de casa, desechando petición.
}
$casa_votos = $db->select("casas", array("casa_id" => $casa_id), array("casa_score"));
print $casa_votos['casa_score'];