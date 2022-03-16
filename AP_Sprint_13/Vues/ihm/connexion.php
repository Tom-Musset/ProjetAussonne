<?php
{
		$_SESSION['key']=bin2hex(random_bytes(32));		
}

$csrf=hash_hmac('sha256','Clé sécurité connexion.php',$_SESSION['key']); // La phrase de sécurité (Clé sécurité connexion.php) peut être changée
?>

<!-- Le bouton qui va lancer la modal -->
<button type="button" class="btn bg-transparent" data-toggle="modal" data-target="#connexion">
  Se connecter
</button>

<!-- La modal -->
<div class="modal fade" id="connexion" tabindex="-1" role="dialog" aria-labelledby="maConnexion" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="maConnexion">Saisir vos identifiants</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div class="container">
			<div class="row">
					<form action=index.php?vue=Connexion&action=Verification method=POST align=center>
						<table class="table table-sm">
							<tbody>
								<tr>
									<td>
											<input type="radio" name="role" value="1" id="admin">
											<label for="admin">Admin</label> <br>
									</td>
									<td>
											<input type="radio" name="role" value="2" id="adherent">
											<label for="adherent">Adherent</label> <br/>
									</td>
									<td>
											<input type="radio" name="role" value="3" id="entraineur">
											<label for="entraineur">Entraineur</label> <br/>
									</td>
								</tr>
								<tr>
									<td>
											<input type=text name=login placeholder="Login"></input>
									</td>
									<td>
											<input type=password name=pwd placeholder="Password"></input>
									</td>
								</tr>
								<tr>		
								</form>		
								</tr>
								
							</tbody>
						</table>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
						<button type="submit" class="btn btn-primary">Valider</button>
						<input type="hidden" name="csrf" value="<?php echo $csrf; ?>">

						
			</div>
		</div>
	  </div>
      
    </div>
  </div>
</div>