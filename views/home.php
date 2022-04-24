<?php if (isset($_SESSION['id_u'])) { ?>
<div class="container mt-4">
	<div class="row d-flex justify-content-center">
		<div class="col-auto">
			<div class="card text-white bg-success mb-3">
  				<div class="card-header">
  					<h3 class="text-center">Bienvenue <?= $_SESSION['pseudo']; ?> !</h3>
  				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<div class="container mt-4">
	<div class="row d-flex justify-content-center">
		<div class="col-auto">
			<div class="card text-white bg-primary mb-3">
  				<div class="card-header">
  					<h3 class="text-center">Bienvenue sur sos-game.fr !</h3>
  				</div>
			</div>
		</div>
	</div>
</div>

<div class="container mt-4">
	<div class="row d-flex justify-content-center">
		<div class="col-auto">
			<div class="card text-white bg-light mb-3">
  				<div class="card-header">
  					<h3 class="text-center text-dark">PREVIEW</h3>
  				</div>
  				<div class="card-body">
  					<a class="btn" href="https://www.jeuxvideo.com/preview/1391650/shin-megami-tensei-iii-nocturne-hd-remaster-est-il-a-la-hauteur-du-j-rpg-culte.htm" target="_blank">
  						Shin Megami Tensei III Nocturne HD Remaster est-il à la hauteur du JRPG culte ?
  					</a>
  				</div>
  				<div class="card-footer">
  					<span class="badge bg-dark">PC</span>
  					<span class="badge bg-danger">Switch</span>
  					<span class="badge bg-primary">PS4</span>
  				</div>
			</div>
		</div>
		<div class="col-auto">
			<div class="card text-white bg-light mb-3">
  				<div class="card-header">
  					<h3 class="text-center text-dark">PREVIEW</h3>
  				</div>
  				<div class="card-body">
  					<a class="btn" href="https://www.jeuxvideo.com/news/1393466/resident-evil-village-demo-et-gameplay-inedit-on-analyse-le-survival-horror-de-capcom.htm" target="_blank">
  						Resident Evil Village : Démo et gameplay inédit, analyse du Survival-Horror
  					</a>
  				</div>
  				<div class="card-footer">
  					<span class="badge bg-dark">PC</span>
  					<span class="badge bg-primary">PS5</span>
  					<span class="badge bg-success">XBOX SERIES</span>
  					<span class="badge bg-primary">PS4</span>
  				</div>
			</div>
		</div>
	</div>
</div>
