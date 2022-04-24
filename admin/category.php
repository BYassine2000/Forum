<?php auth(3);

$category = $bdd->query("SELECT * FROM category ORDER BY id_cat DESC");

if (isset($_POST['add-category'])) {
	$titre_cat = $_POST['titre_cat'];
	$lien_cat = $_POST['lien_cat'];
	if ($titre_cat != "" && $lien_cat != "") {
		$check_titre_exist = $bdd->prepare("SELECT titre_cat FROM category WHERE titre_cat = :titre_cat");
		$check_titre_exist->bindValue(':titre_cat', $titre_cat, PDO::PARAM_STR);
		$check_titre_exist->execute();
		$check_titre_exist = $check_titre_exist->fetch();
		if (!$check_titre_exist) {
			$check_lien_exist = $bdd->prepare("SELECT lien_cat FROM category WHERE lien_cat = :lien_cat");
			$check_lien_exist->bindValue(':lien_cat', $lien_cat, PDO::PARAM_STR);
			$check_lien_exist->execute();
			$check_lien_exist = $check_lien_exist->fetch();
			if (!$check_lien_exist) {
				$insertion = $bdd->prepare("INSERT INTO category (titre_cat, lien_cat) VALUES (:titre_cat, :lien_cat)");
				$insertion->bindValue(':titre_cat', $titre_cat, PDO::PARAM_STR);
				$insertion->bindValue(':lien_cat', $lien_cat, PDO::PARAM_STR);
				$insertion->execute();
				header('Location: category');
			} else {
				Alerts::setFlash("Ce lien existe déjà !", "danger");
			}
		} else {
			Alerts::setFlash("Ce titre existe déjà !", "danger");
		}
	} else {
		Alerts::setFlash("Veuillez compléter tous les champs !", "warning");
	}
}

if (isset($_POST['retour'])) {
	header('Location: category');
}

if (isset($_POST['modifier'])) {
	$id_cat = $_GET['edit'];
	$titre_cat = $_POST['titre_cat'];
	$lien_cat = $_POST['lien_cat'];
	if ($titre_cat != "" && $lien_cat != "") {
		$update = $bdd->prepare("UPDATE category SET titre_cat = :titre_cat, lien_cat = :lien_cat WHERE id_cat = :id_cat");
		$update->bindValue(':titre_cat', $titre_cat, PDO::PARAM_STR);
		$update->bindValue(':lien_cat', $lien_cat, PDO::PARAM_STR);
		$update->bindValue(':id_cat', $id_cat, PDO::PARAM_INT);
		$update->execute();
		header('Location: category');
	} else {
		Alerts::setFlash("Les champs ne doivent pas être vide !", "warning");
	}
}

if (isset($_GET['id_cat'])) {
	$id_cat = $_GET['id_cat'];
	$delete = $bdd->prepare("DELETE FROM category WHERE id_cat = :id_cat");
	$delete->bindValue('id_cat', $id_cat, PDO::PARAM_INT);
	$delete->execute();
	header('Location: category');
}

?>
<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../assets/css/headers.css">
<div class="container mt-4">
	<div class="row d-flex justify-content-center">
		<div class="col-12">
			<h3 class="text-center mb-3">Liste des catégories</h3>
			<div class="d-flex justify-content-center mb-3">
				<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-category">
					Ajouter une catégorie
				</button>
			</div>
			<div class="mb-3 d-flex justify-content-center">
				<?= Alerts::getFlash(); ?>
			</div>
			<table class="table">
  				<thead>
    				<tr>
      					<th scope="col">#</th>
      					<th scope="col">Titres</th>
      					<th scope="col">Liens</th>
      					<th scope="col">Actions</th>
    				</tr>
  				</thead>
  				<tbody>
    				<?php foreach ($category as $cat) { ?>
	                <?php if (isset($_GET['edit'])) { ?>
					<tr>
						<form method="post" action="">
							<td><?= $cat['id_cat']; ?></td>
							<td>
								<input type="text" name="titre_cat" class="form-control" value="<?= $cat['titre_cat']; ?>">
							</td>
							<td>
								<input type="text" name="lien_cat" class="form-control" value="<?= $cat['lien_cat']; ?>">
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
						<td><?= $cat['id_cat']; ?></td>
						<td><?= $cat['titre_cat']; ?></td>
						<td><?= $cat['lien_cat']; ?></td>
						<td>
							<a class="btn btn-primary font-weight-bolder me-2" href="category&edit=<?= $cat['id_cat']; ?>">
	                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
										<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
										<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
								</svg>
	                        </a>
	                        <a class="btn btn-danger font-weight-bolder" href="category&id_cat=<?= $cat['id_cat']; ?>" onclick="return(confirm('Voulez-vous vraiment supprimer cette catégorie ?'));">
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

<div class="modal fade" id="modal-category" tabindex="-1" aria-hidden="true">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h5 class="modal-title">Ajouter une categorie</h5>
        		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      		</div>
      		<div class="modal-body">
        		<form method="post" action="">
        			<?= $helper->input('titre_cat', 'Nom de la catégorie', 'text'); ?>
        			<?= $helper->input('lien_cat', 'Nom de la page de la catégorie', 'text'); ?>
					<div class="d-flex justify-content-center mt-4">
	        			<button type="submit" name="add-category" class="btn btn-primary btn-lg">Créer une catégorie</button>
	        		</div>
        		</form>
      		</div>
    	</div>
  	</div>
</div>