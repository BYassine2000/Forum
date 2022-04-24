<div class="container mt-4">
	<div class="row d-flex justify-content-center">
		<div class="col-auto">
			<div class="card text-white bg-primary mb-3">
  				<div class="card-header">
  					<h3 class="text-center">Bienvenue dans la catégorie jeux-vidéos !</h3>
  				</div>
			</div>
			<h3 class="mb-5">Liste des topics</h3>
			<div class="list-group">
				<?php foreach ($topics as $topic) { ?>
  				<a href="javascript:void(0)" class="list-group-item list-group-item-action"><?= $topic['titre_top']; ?> - <?= $topic['description']; ?></a>
  				<?php } ?>
			</div>
		</div>
	</div>
</div>
