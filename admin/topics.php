<?php auth(3);

$topics = $bdd->query("SELECT * FROM topics ORDER BY id_t DESC");

if (isset($_POST['add-topic'])) {
	$id_cat = $_POST['id_cat'];
	$titre_top = $_POST['titre_top'];
	$description = $_POST['description'];
	if ($titre_top != "" && $description != "") {
		$check_titre_exist = $bdd->prepare("SELECT titre_top FROM topics WHERE titre_top = :titre_top");
		$check_titre_exist->bindValue(':titre_top', $titre_top, PDO::PARAM_STR);
		$check_titre_exist->execute();
		$check_titre_exist = $check_titre_exist->fetch();
		if (!$check_titre_exist) {
			$insertion = $bdd->prepare("INSERT INTO topics (id_cat, titre_top, description) VALUES (:id_cat, :titre_top, :description)");
			$insertion->bindValue(':id_cat', $id_cat, PDO::PARAM_INT);
			$insertion->bindValue(':titre_top', $titre_top, PDO::PARAM_STR);
			$insertion->bindValue(':description', $description, PDO::PARAM_STR);
			$insertion->execute();
			header('Location: topics');
		} else {
			Alerts::setFlash("Ce titre existe déjà !", "danger");
		}
	} else {
		Alerts::setFlash("Veuillez compléter tous les champs !", "warning");
	}
}

if (isset($_POST['retour'])) {
	header('Location: topics');
}

if (isset($_POST['modifier'])) {
	$id_t = $_GET['edit'];
	$id_cat = $_POST['id_cat'];
	$titre_top = $_POST['titre_top'];
	$description = $_POST['description'];
	if ($titre_top != "" && $description != "") {
		$update = $bdd->prepare("UPDATE topics SET id_cat = :id_cat, titre_top = :titre_top, description = :description WHERE id_t = :id_t");
		$update->bindValue(':id_cat', $id_cat, PDO::PARAM_INT);
		$update->bindValue(':titre_top', $titre_top, PDO::PARAM_STR);
		$update->bindValue(':description', $description, PDO::PARAM_STR);
		$update->bindValue(':id_t', $id_t, PDO::PARAM_INT);
		$update->execute();
		header('Location: topics');
	} else {
		Alerts::setFlash("Les champs ne doivent pas être vide !", "warning");
	}
}

if (isset($_GET['id_t'])) {
	$id_t = $_GET['id_t'];
	$delete = $bdd->prepare("DELETE FROM topics WHERE id_t = :id_t");
	$delete->bindValue('id_t', $id_t, PDO::PARAM_INT);
	$delete->execute();
	header('Location: topics');
}

?>
<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../assets/css/headers.css">
<div class="container mt-4">
	<div class="row d-flex justify-content-center">
		<div class="col-12">
			<h3 class="text-center mb-3">Liste des topics</h3>
			<div class="d-flex justify-content-center mb-3">
				<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-topic">
					Ajouter un topic
				</button>
			</div>
			<div class="mb-3 d-flex justify-content-center">
				<?= Alerts::getFlash(); ?>
			</div>
			<table class="table">
  				<thead>
    				<tr>
      					<th scope="col">#</th>
      					<th scope="col">Catégories</th>
      					<th scope="col">Topics</th>
      					<th scope="col">Description</th>
      					<th scope="col">Actions</th>
    				</tr>
  				</thead>
  				<tbody>
    				<?php foreach ($topics as $topic) { ?>
	                <?php if (isset($_GET['edit'])) { ?>
					<tr>
						<form method="post" action="">
							<td><?= $topic['id_t']; ?></td>
							<td>
								<input type="text" name="id_cat" class="form-control" value="<?= $topic['id_cat']; ?>">
							</td>
							<td>
								<input type="text" name="titre_top" class="form-control" value="<?= $topic['titre_top']; ?>">
							</td>
							<td>
								<textarea name="description" class="form-control"><?= $topic['description']; ?></textarea>
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
						<td><?= $topic['id_t']; ?></td>
						<td><?= $topic['id_cat']; ?></td>
						<td><?= $topic['titre_top']; ?></td>
						<td><?= $topic['description']; ?></td>
						<td>
							<a class="btn btn-primary font-weight-bolder me-2" href="topics&edit=<?= $topic['id_t']; ?>">
	                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
										<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
										<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
								</svg>
	                        </a>
	                        <a class="btn btn-danger font-weight-bolder" href="topics&id_t=<?= $topic['id_t']; ?>" onclick="return(confirm('Voulez-vous vraiment supprimer ce topic ?'));">
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

<div class="modal fade" id="modal-topic" tabindex="-1" aria-hidden="true">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h5 class="modal-title">Ajouter un topic</h5>
        		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      		</div>
      		<div class="modal-body">
        		<form method="post" action="">
        			<div class="mb-3">
        				<label for="category" class="form-label">Catégorie</label>
						<select name="id_cat" id="category" class="form-select">
							<?php $requete = $bdd->query("SELECT * FROM category");
							$lesCategories = $requete->fetchAll();
							foreach ($lesCategories as $uneCategorie) { ?>
							<option value="<?= $uneCategorie['id_cat']; ?>"><?= $uneCategorie['titre_cat']; ?></option>
							<?php } ?>
						</select>
        			</div>
        			<?= $helper->input('titre_top', 'Nom du topic', 'text'); ?>
        			<?= $helper->textarea('description', 'Description du topic'); ?>
					<div class="d-flex justify-content-center mt-4">
	        			<button type="submit" name="add-topic" class="btn btn-primary btn-lg">Créer un topic</button>
	        		</div>
        		</form>
      		</div>
    	</div>
  	</div>
</div>