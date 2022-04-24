<?php 

require('models/homeModels.php');

$categories = getAllCategory();

if (isset($_POST['connexion'])) {
	$pseudo = $_POST['pseudo'];
	$mdp = sha1($_POST['mdp']);
	if ($pseudo != "" && $mdp != "") {
		$user = getUsers($pseudo, $mdp);
		if ($user) {
			$session->setVar('id_u', $user['id_u']);
            $session->setVar('pseudo', $user['pseudo']);
            $session->setVar('email', $user['email']);
           	$session->setVar('lvl', $user['lvl']);
		} else {
			Alerts::setFlash("Identifiants incorrects !", "danger");
		}
	} else {
		Alerts::setFlash("Veuillez complétez tous les champs !", "warning");
	}
}

if (isset($_POST['inscription'])) {
	$pseudo = $_POST['pseudo'];
	$email = $_POST['email'];
	$mdp = sha1($_POST['mdp']);
	$mdp2 = sha1($_POST['mdp2']);
	if ($pseudo != "" && $email != "" && $mdp != "" && $mdp2 != "") {
		if (preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,6}$#", $email)) {
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$requete_check_pseudo = checkPseudo($pseudo);
				if (!$requete_check_pseudo) {
					$requete_check_email = checkEmail($email);
					if (!$requete_check_email) {
						if ($mdp == $mdp2) {
							$insertion = insertUser($pseudo, $email, $mdp);
							Alerts::setFlash("Votre compte à bien été créer !");
						} else {
							Alerts::setFlash("Les mots de passes ne correspondent pas !", "warning");
						}
					} else {
						Alerts::setFlash("Adresse email déjà utilisé !", "danger");
					}
				} else {
					Alerts::setFlash("Pseudo déjà utilisé !", "danger");
				}
			} else {
				Alerts::setFlash("Format de l'adresse email invalid !", "warning");
			}
		} else {
			Alerts::setFlash("Format de l'adresse email invalid !", "warning");
		}
	} else {
		Alerts::setFlash("Veuillez complétez tous les champs !", "warning");
	}
}

require('views/home.php');

?>