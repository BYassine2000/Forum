<?php

function updatePseudo($pseudo) {
	global $bdd;
	$requete_update_pseudo = $bdd->prepare("UPDATE users SET pseudo = :pseudo WHERE id_u = ".$_SESSION['id_u']);
	$requete_update_pseudo->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
	return $requete_update_pseudo->execute();
}

function checkEmail($email) {
	global $bdd;
	$requete_email_exist = $bdd->prepare("SELECT * FROM users WHERE email = :email");
	$requete_email_exist->bindValue(':email', $email, PDO::PARAM_STR);
	$requete_email_exist->execute();
	return $requete_email_exist->fetchAll();
}

function updateEmail($email) {
	global $bdd;
	$requete_update_email = $bdd->prepare("UPDATE users SET email = :email WHERE id_u = ".$_SESSION['id_u']);
	$requete_update_email->bindValue(':email', $email, PDO::PARAM_STR);
	return $requete_update_email->execute();
}

function checkMdp($mdp) {
	global $bdd;
	$requete_mdp_user = $bdd->prepare("SELECT mdp FROM users WHERE mdp = :mdp");
	$requete_mdp_user->bindValue(':mdp', $mdp, PDO::PARAM_STR);
	$requete_mdp_user->execute();
	return $requete_mdp_user->fetch();
}

function updateMdp($newmdp) {
	global $bdd;
	$requete_update_mdp = $bdd->prepare("UPDATE users SET mdp = :mdp WHERE id_u = ".$_SESSION['id_u']);
	$requete_update_mdp->bindValue(':mdp', $newmdp, PDO::PARAM_STR);
	return $requete_update_mdp->execute();
}

function checkUser($email, $mdp) {
	global $bdd;
	$requete_check_user = $bdd->prepare("SELECT * FROM users WHERE email = :email AND mdp = :mdp");
	$requete_check_user->bindValue(':email', $email, PDO::PARAM_STR);
	$requete_check_user->bindValue(':mdp', $mdp, PDO::PARAM_STR);
	$requete_check_user->execute();
	return $requete_check_user->fetchAll();
}

function deleteUser() {
	global $bdd;
	$delete_account = $bdd->prepare("DELETE FROM users WHERE id_u = ".$_SESSION['id_u']);
	return $delete_account->execute();
}

?>