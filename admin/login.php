<?php

if (isset($_POST['connexion'])) {
	$email = $_POST['email'];
	$mdp = sha1($_POST['mdp']);
	if ($email != "" && $mdp != "") {
		$admin = $bdd->prepare("SELECT * FROM users WHERE email = :email AND mdp = :mdp");
		$admin->bindValue(':email', $email, PDO::PARAM_STR);
		$admin->bindValue(':mdp', $mdp, PDO::PARAM_STR);
		$admin->execute();
		$admin = $admin->fetch();
		if ($admin) {
			$session->setVar('id_u', $admin['id_u']);
            $session->setVar('pseudo', $admin['pseudo']);
            $session->setVar('email', $admin['email']);
           	$session->setVar('lvl', $admin['lvl']);
           	if ($admin['lvl'] == 1) {
           		Alerts::setFlash("<strong>Vous n'avez pas la permission d'accéder !</strong>", "danger");
           	} elseif ($admin['lvl'] == 2) {
           		Alerts::setFlash("<strong>Vous n'avez pas la permission d'accéder !</strong>", "danger");
           	} elseif ($admin['lvl'] == 3) {
           		header('Location: admin-panel/users');
           	}
		} else {
			Alerts::setFlash("Identifiants incorrects !", "danger");
		}
	} else {
		Alerts::setFlash("Veuillez complétez tous les champs !", "warning");
	}
}

?>

<div class="container mt-4">
	<div class="row d-flex justify-content-center">
		<div class="col-xxl-4">
			<div class="card text-white bg-dark mb-3">
  				<div class="card-header">
  					<h3 class="text-center">Administration</h3>
  				</div>
  				<div class="card-body">
    				<form method="post" action="">
						<div class="mb-3">
							<label for="email" class="form-label">Adresse email</label>
							<input type="email" name="email" id="email" class="form-control" required="required">
						</div>
						<div class="mb-4">
							<label for="mdp" class="form-label">Mot de passe</label>
							<input type="password" name="mdp" id="mdp" class="form-control" required="required">
						</div>
						<div class="d-flex justify-content-center">
							<button type="submit" name="connexion" class="btn btn-primary">Connexion</button>
						</div>
					</form>
  				</div>
			</div>
		</div>
	</div>
</div>