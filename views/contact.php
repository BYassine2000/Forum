<div class="container mt-4">
	<div class="row d-flex justify-content-center">
		<div class="col-xxl-5">
			<div class="card">
				<div class="card-header">
					<h3 class="text-center">Nous contacter</h3>
				</div>
				<form method="post" action="">
					<div class="card-body">
						<div class="mb-3">
							<label for="email" class="form-label">Adresse email</label>
							<input type="email" name="email" id="email" class="form-control" required="required">
						</div>
						<div class="mb-3">
							<label for="sujet" class="form-label">Sujet du message</label>
							<input type="text" name="sujet" id="sujet" class="form-control" required="required">
						</div>
						<div class="mb-3">
							<label for="message" class="form-label">Message</label>
							<textarea name="message" id="message" class="form-control" required="required"></textarea>
						</div>
					</div>
					<div class="card-footer">
						<div class="d-flex justify-content-center">
							<button type="reset" class="btn btn-danger me-2">Annuler</button>
							<button type="submit" name="submit" class="btn btn-primary">Envoyer</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>