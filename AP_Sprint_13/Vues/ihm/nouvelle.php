<?php echo '<p align=center>Choisir le thème des nouvelles que vous souhaitez afficher </p><br>
					               <form action=index.php method=GET align=center>';
									$_GET['vue']='Connexion';
									$_GET['action']='initialiserTypeNouvelle';
									$this->affichePage($_GET['action'],$_GET['vue'],$role);
									echo '<br>  <br>
									<input type=hidden name=vue value=Connexion></input>
									<input type=hidden name=action value=typeChoixNouvelle></input>
									<button type="submit" class="btn btn-primary">Valider</button>
							 </form>
					
				</div>
				<div class="col-md-10 col-xs-12 ">';
				?>