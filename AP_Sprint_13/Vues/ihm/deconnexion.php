<!-- Le bouton qui va lancer la modal -->
<button type="button" class="btn bg-transparent" data-toggle="modal" data-target="#deconnexion">
  Deconnexion
</button>

<!-- La modal -->
<div class="modal fade" id="deconnexion" tabindex="-1" role="dialog" aria-labelledby="maDeConnexion" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="maDeConnexion">Se déconnecter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div class="container">
			<div class="row">
					<form action=index.php?vue=Connexion&action=Deconnexion method=POST align=center style="width:100%">
						Etes-vous certain de vouloir vous déconnecter ?
            <br><br>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-primary">Valider</button>
					</form>
			</div>
		</div>
	  </div>
      
    </div>
  </div>
</div>