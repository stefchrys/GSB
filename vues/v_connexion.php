	<!--debut connexion -->
	<div class="row clearfix"  >
		<div class="col-md-4 column">
		</div>
		<div class="col-md-4 column" id="contenu" >
			<form role="form" method="POST" action="index.php?uc=connexion&action=valideConnexion">
				<h3 class='text-center'>
					Identification utilisateur .
				</h3>
				<div class="form-group" >
					 <label for="login">Login*</label>
					 <input class="form-control" id="login" type="text" name="txt_login" required>
				</div>
				<div class="form-group">
					 <label for="mdp">Password*</label>
					 <input class="form-control" id="mdp" type="password" name="txt_mdp" required>
				</div>
				
				 <button type="submit" class="btn btn-default">Valider</button>
			</form>
		</div>
		<div class="col-md-4 column">
		</div>
	</div>
	<!-- fin connexion -->