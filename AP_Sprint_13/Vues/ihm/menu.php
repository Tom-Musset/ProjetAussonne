<div class="dropdown col">
	<button class="btn bg-transparent dropdown-toogle" type="button" id="menuEntraineur" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Menu Specialite 
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" aria-labelledby="menuSpecialite">
		<li><a class="dropdown-item" href='index.php?vue=Specialite&action=visualiser'>Visualiser les specialites</a></li>
	</ul>
</div>
<div class="dropdown col">
	<button class="btn bg-transparent dropdown-toogle" type="button" id="menuEntraineur" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Menu Entraîneur 
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" aria-labelledby="menuEntraineur">
		<li><a class="dropdown-item" href='index.php?vue=Entraineur&action=visualiser'>Visualiser les entraineurs</a></li>
	</ul>
</div>
<div class="dropdown col">
	<button class="btn bg-transparent dropdown-toogle" type="button" id="menuEquipe" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		Menu Equipe 
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" aria-labelledby="menuEquipe">
		<li><a class="dropdown-item" href = 'index.php?vue=Equipe&action=visualiser'>Visualiser les équipes</a></li>
		<li><a class="dropdown-item" href = 'index.php?vue=Equipe&action=visualiserParSpecialites'>Visualiser les équipes par specialités</a></li>
	</ul>
</div>
<div class="dropdown col">
	<button class="btn bg-transparent dropdown-toogle" type="button" id="menuAdherent" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		Menu Adherent 
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" aria-labelledby="menuAdherent">
		<li><a class="dropdown-item" href = 'index.php?vue=Adherent&action=visualiser'>Visualiser les Adherents</a></li>
	</ul>
</div>
<div class="dropdown col">
	<button class="btn bg-transparent dropdown-toogle" type="button" id="contact" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		Contact 
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" aria-labelledby="contact">
		<li><a class="dropdown-item" href = 'index.php?vue=Connexion&action=contact'>Laisser un message</a></li>
	</ul>
</div>

</div>
</div>

		<div class="container">
			<div class="row">
				<div class ="col-md-2 col-xs-12 infosComplementaires">
					<?php require "vues/ihm/connexion.php";?>
					<?php require "vues/ihm/deconnexion.php";?>
					<br> <p align=center>Choisir le thème des nouvelles que vous souhaitez afficher </p><br>
					<?php 
						echo '<script type="text/javascript" src="Outil/ajax.js"></script><form align=center>';
									$_GET['vue']='Connexion';
									$_GET['action']='initialiserTypeNouvelle';
									$monControleur->affichePage($_GET['action'],$_GET['vue'],$role);
									echo '<br> <br> 
									<input type=hidden name=vue value=Connexion></input>
									<input type=hidden name=action value=typeChoixNouvelle></input>
									<button type="button" class="btn btn-primary" onClick="appelAjax();">Valider</button>
							 </form>';
					?>
				</div><!--
				<div id="contenuajax" class="col-md-10 col-xs-12 "></div>-->