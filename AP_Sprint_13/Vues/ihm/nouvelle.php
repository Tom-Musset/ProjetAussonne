<?php
/* echo '<p align=center>Choisir le thème des nouvelles que vous souhaitez afficher </p><br>
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
				*/

				
				echo '<script type="text/javascript" src="Outil/ajax.js"></script><p align=center>Choisir le thème des nouvelles que vous souhaitez afficher </p><br>
					               <form  align=center>';
									$_GET['vue']='Connexion';
									$_GET['action']='initialiserTypeNouvelle';
									$this->affichePage($_GET['action'],$_GET['vue'],$role);
									echo '<br>  <br>
									<input type=hidden name=vue value=Connexion></input>
									<input type=hidden name=action value=typeChoixNouvelle></input>
									<button type="button" class="btn btn-primary" onClick="appelAjax();">Valider</button>
							 </form>
					
				</div>
				<div id="contenuajax" class="col-md-10 col-xs-12 ">';
				?>	
				