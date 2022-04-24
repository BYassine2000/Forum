<?php

$categories = $bdd->query("SELECT * FROM category ORDER BY id_cat DESC");
$categories->execute();
$categories = $categories->fetchAll(); 

?>
<!DOCTYPE html>
<html>
<head>
	<title>sos-game.fr</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/headers.css">
</head>
<body>

<nav class="py-2 bg-light border-bottom">
  	<div class="container d-flex flex-wrap">
    	<ul class="nav me-auto">
      		<li class="nav-item">
      			<a href="home" class="nav-link link-dark px-2">Accueil</a>
      		</li>
      		<li class="nav-item dropdown">
          		<a class="nav-link link-dark dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Catégories</a>
          		<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          			<?php foreach ($categories as $categorie) { ?>
            		<li><a class="dropdown-item" href="<?= $categorie['lien_cat']; ?>"><?= $categorie['titre_cat']; ?></a></li>
            		<?php } ?>
          		</ul>
        	</li>
        	<?php if (isset($_SESSION['id_u']) && $_SESSION['lvl'] == 3) { ?>
        	<li class="nav-item">
      			<a href="users" class="nav-link link-dark px-2">Utilisateurs</a>
      		</li>
      		<li class="nav-item">
      			<a href="category" class="nav-link link-dark px-2">Catégories</a>
      		</li>
      		<li class="nav-item">
      			<a href="topics" class="nav-link link-dark px-2">Topics</a>
      		</li>
        	<?php } ?>
      		<li class="nav-item">
      			<a href="contact" class="nav-link link-dark px-2">Contact</a>
      		</li>
    	</ul>
    	<ul class="nav">
    		<?php if (!isset($_SESSION['id_u'])) { ?>
      		<li class="nav-item">
      			<a class="nav-link link-dark px-2" data-bs-toggle="modal" href="#login-form">Connexion</a>
      		</li>
      		<li class="nav-item">
      			<a class="nav-link link-dark px-2" data-bs-toggle="modal" href="#signup-form">Inscription</a>
      		</li>
      		<?php } else { ?>
      		<li class="nav-item">
      			<a class="nav-link link-dark px-2" href="profile">Mon profil</a>
      		</li>
      		<li class="nav-item">
      			<a class="nav-link link-dark px-2" href="logout">Déconnexion</a>
      		</li>
      		<?php } ?>
    	</ul>
  	</div>
</nav>
<header class="py-3 mb-4 border-bottom">
  	<div class="container d-flex flex-wrap justify-content-center">
    	<a href="http://localhost/Forum/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
      		<span class="fs-4">sos-game.fr</span>
    	</a>
    	<form method="post" action="" class="col-12 col-lg-auto mb-3 mb-lg-0">
      		<input type="search" name="search" placeholder="Rechercher" class="form-control">
    	</form>
  	</div>
</header>

<?= $contents; ?>

<div class="container">
	<div class="row d-flex justify-content-center">
		<div class="col-auto">
			<?= Alerts::getFlash(); ?>
		</div>
	</div>
</div>

<div class="modal fade" id="login-form" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h5 class="modal-title">Formulaire de connexion</h5>
        		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      		</div>
      		<div class="modal-body">
        		<form method="post" action="">
        			<div class="mb-3">
        				<label for="pseudo" class="form-label">Pseudo</label>
        				<input type="text" name="pseudo" id="pseudo" class="form-control" required="required">
        			</div>
        			<div class="mb-3">
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

<div class="modal fade" id="signup-form" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h5 class="modal-title">Formulaire d'inscription</h5>
        		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      		</div>
      		<div class="modal-body">
        		<form method="post" action="">
        			<div class="mb-3">
        				<label for="pseudo" class="form-label">Pseudo</label>
        				<input type="text" name="pseudo" id="pseudo" class="form-control" required="required">
        			</div>
        			<div class="mb-3">
        				<label for="email" class="form-label">Adresse email</label>
        				<input type="email" name="email" id="email" class="form-control" required="required">
        			</div>
        			<div class="mb-3">
        				<label for="mdp" class="form-label">Mot de passe</label>
        				<input type="password" name="mdp" id="mdp" class="form-control" required="required">
        			</div>
        			<div class="mb-3">
        				<label for="mdp2" class="form-label">Confirmation du mot de passe</label>
        				<input type="password" name="mdp2" id="mdp2" class="form-control" required="required">
        			</div>
        			<div class="d-flex justify-content-center">
        				<button type="submit" name="inscription" class="btn btn-primary">Créer un compte</button>
        			</div>
        		</form>
      		</div>
    	</div>
  	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>

</body>
</html>