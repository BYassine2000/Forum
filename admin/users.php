<?php auth(3);

$users = $bdd->query("SELECT * FROM users ORDER BY id_u DESC");

if (isset($_POST['add-user'])) {
	$pseudo = $_POST['pseudo'];
	$email = $_POST['email'];
	$mdp = sha1($_POST['mdp']);
	$lvl = $_POST['lvl'];
	if ($pseudo != "" && $email != "" && $mdp != "") {
		if (preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,6}$#", $email)) {
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$check_email_exist = $bdd->prepare("SELECT email FROM users WHERE email = :email");
				$check_email_exist->bindValue(':email', $email, PDO::PARAM_STR);
				$check_email_exist->execute();
				$check_email_exist = $check_email_exist->fetch();
				if (!$check_email_exist) {
					$insertion = $bdd->prepare("INSERT INTO users (pseudo, email, mdp, lvl) VALUES (:pseudo, :email, :mdp, :lvl)");
					$insertion->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
					$insertion->bindValue(':email', $email, PDO::PARAM_STR);
					$insertion->bindValue(':mdp', $mdp, PDO::PARAM_STR);
					$insertion->bindValue(':lvl', $lvl, PDO::PARAM_INT);
					$insertion->execute();
					header('Location: users');
				} else {
					Alerts::setFlash("Cette adresse email a déjà été enregistrée !", "danger");
				}
			} else {
				Alerts::setFlash("Format de l'adresse email invalide !", "danger");
			}
		} else {
			Alerts::setFlash("Format de l'adresse email invalide !", "danger");
		}
	} else {
		Alerts::setFlash("Veuillez compléter tous les champs !", "warning");
	}
}

if (isset($_POST['retour'])) {
	header('Location: users');
}

if (isset($_POST['modifier'])) {
	$id_u = $_GET['edit'];
	$pseudo = $_POST['pseudo'];
	$email = $_POST['email'];
	$lvl = $_POST['lvl'];
	if ($pseudo != "" && $email != "") {
		$update = $bdd->prepare("UPDATE users SET pseudo = :pseudo, email = :email, lvl = :lvl WHERE id_u = :id_u");
		$update->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
		$update->bindValue(':email', $email, PDO::PARAM_STR);
		$update->bindValue(':lvl', $lvl, PDO::PARAM_INT);
		$update->bindValue(':id_u', $id_u, PDO::PARAM_INT);
		$update->execute();
		header('Location: users');
	} else {
		Alerts::setFlash("Les champs ne doivent pas être vide !", "warning");
	}
}

if (isset($_GET['id_u'])) {
	$id_u = $_GET['id_u'];
	$delete = $bdd->prepare("DELETE FROM users WHERE id_u = :id_u");
	$delete->bindValue('id_u', $id_u, PDO::PARAM_INT);
	$delete->execute();
	header('Location: users');
}

?>
<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../assets/css/headers.css">
<div class="container mt-4">
	<div class="row d-flex justify-content-center">
		<div class="col-12">
			<h3 class="text-center mb-3">Liste des utilisateurs</h3>
			<div class="d-flex justify-content-center mb-3">
				<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-user">
					Ajouter un utilisateur
				</button>
			</div>
			<div class="mb-3 d-flex justify-content-center">
				<?= Alerts::getFlash(); ?>
			</div>
			<table class="table">
  				<thead>
    				<tr>
      					<th scope="col">#</th>
      					<th scope="col">Pseudo</th>
      					<th scope="col">Adresse email</th>
      					<th scope="col">Droits</th>
      					<th scope="col">Actions</th>
    				</tr>
  				</thead>
  				<tbody>
    				<?php foreach ($users as $user) { ?>
	                <?php if (isset($_GET['edit'])) { ?>
					<tr>
						<form method="post" action="">
							<td><?= $user['id_u']; ?></td>
							<td>
								<input type="text" name="pseudo" class="form-control" value="<?= $user['pseudo']; ?>">
							</td>
							<td>
								<input type="email" name="email" class="form-control" value="<?= $user['email']; ?>">
							</td>
							<td>
								<select name="lvl" class="from-select">
									<option value="1">Utilisateur</option>
									<option value="2">Modérateur</option>
									<option value="3">Administrateur</option>
								</select>
							</td>
							<td>
								<button type="submit" name="modifier" class="btn btn-primary me-2">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
											<path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
									</svg>
								</button>
								<button type="submit" name="retour" class="btn btn-danger">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
											<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
									</svg>
								</button>
							</td>
						</form>
					</tr>
					<?php } else { ?>
					<tr>
						<td><?= $user['id_u']; ?></td>
						<td><?= $user['pseudo']; ?></td>
						<td><?= $user['email']; ?></td>
						<td>
							<?php if ($user['lvl'] == 1) { ?>
							<span class="badge rounded-pill bg-info text-light text-lg">Utilisateur</span>
							<?php } elseif ($user['lvl'] == 2) { ?>
							<span class="badge rounded-pill bg-primary text-lg">Modérateur</span>
							<?php } elseif($user['lvl'] == 3) { ?>
							<span class="badge rounded-pill bg-danger text-lg">Administrateur</span>
							<?php } ?>
						</td>
						<td>
							<a class="btn btn-primary font-weight-bolder me-2" href="users&edit=<?= $user['id_u']; ?>">
	                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
										<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
										<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
								</svg>
	                        </a>
	                        <a class="btn btn-danger font-weight-bolder" href="users&id_u=<?= $user['id_u']; ?>" onclick="return(confirm('Voulez-vous vraiment supprimer cet utilisateur ?'));">
	                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
										<path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
								</svg>
	                        </a>
						</td>
					</tr>
					<?php } ?>
	                <?php } ?>
  				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-user" tabindex="-1" aria-hidden="true">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h5 class="modal-title">Ajouter un utilisateur</h5>
        		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      		</div>
      		<div class="modal-body">
        		<form method="post" action="">
        			<?= $helper->input('pseudo', 'Pseudo', 'text'); ?>
					<?= $helper->input('email', 'Adresse email', 'email'); ?>
					<?= $helper->input('mdp', 'Mot de passe', 'password'); ?>
					<?= $helper->select('lvl', 'Droits', 'lvl', array("1" => "Utilisateur", "2" => "Modérateur", "3" => "Administrateur")); ?>
					<div class="d-flex justify-content-center mt-4">
	        			<button type="submit" name="add-user" class="btn btn-primary btn-lg">Créer un utilisateur</button>
	        		</div>
        		</form>
      		</div>
    	</div>
  	</div>
</div>