<?php

function getAllCategory() {
    global $bdd;
    $categories = $bdd->query("SELECT * FROM category ORDER BY id_cat DESC");
    $categories->execute();
    return $categories->fetchAll(); 
}

function getUsers($pseudo, $mdp) {
	global $bdd;
	$user = $bdd->prepare("SELECT * FROM users WHERE pseudo = :pseudo AND mdp = :mdp");
	$user->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
	$user->bindValue(':mdp', $mdp, PDO::PARAM_STR);
	$user->execute();
	return $user->fetch();
}

function checkPseudo($pseudo) {
	global $bdd;
	$requete_check_pseudo = $bdd->prepare("SELECT pseudo FROM users WHERE pseudo = :pseudo");
	$requete_check_pseudo->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
	$requete_check_pseudo->execute();
	return $requete_check_pseudo->fetch();
}

function checkEmail($email) {
	global $bdd;
	$requete_check_email = $bdd->prepare("SELECT email FROM users WHERE email = :email");
	$requete_check_email->bindValue(':email', $email, PDO::PARAM_STR);
	$requete_check_email->execute();
	return $requete_check_email->fetch();
}

function insertUser($pseudo, $email, $mdp) {
	global $bdd;
	$insertion = $bdd->prepare("INSERT INTO users (pseudo, email, mdp, droits, lvl) VALUES (:pseudo, :email, :mdp, 'utilisateur', 1)");
	$insertion->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
	$insertion->bindValue(':email', $email, PDO::PARAM_STR);
	$insertion->bindValue(':mdp', $mdp, PDO::PARAM_STR);
	return $insertion->execute();
}

?>