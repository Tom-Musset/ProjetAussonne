<?php
	
	class vueCentraleConnexion
	{
		public function __construct()
		{
			
		}
		
		public function AfficherMenuContextuel($role,$existe)
		{
			
			if($existe==1)
			{	switch($role)
				{
					case "2" : 
						$this->afficheMenuAdherent();
						
						break;
					case "3" :
						$this->afficheMenuEntraineur();
						
						break;
					case "1" : 
						$this->afficheMenuAdmin();
						break;
					case "4" : 
						echo "<script > alert('selectionnez un rôle pour vous connecter'); </script>";
						break;
				}
			}
			else
			{
				//header('Location: index.php?erreur=1');
				echo "erreur dans le login ou le mot de passe";
				$this->afficheMenuInternaute();
			}
		}
		
		public function afficheMenuInternaute()
		{
			echo '<div class="dropdown col">
			<button class="btn bg-transparent dropdown-toogle" type="button" id="menuSpecialite" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Menu Specialite 
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" aria-labelledby="menuSpecialite">
				<li><a class="dropdown-item" href=index.php?vue=Specialite&action=visualiser>Visualiser les specialites</a></li>
			</ul>
			</div>
			<div class="dropdown col">
				<button class="btn bg-transparent dropdown-toogle" type="button" id="menuEntraineur" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Menu Entraîneur 
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="menuEntraineur">
					<li><a class="dropdown-item" href=index.php?vue=Entraineur&action=visualiser>Visualiser les entraineurs</a></li>
				</ul>
			</div>
			<div class="dropdown col">
				<button class="btn bg-transparent dropdown-toogle" type="button" id="menuEquipe" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Menu Equipe 
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="menuEquipe">
					<li><a class="dropdown-item" href=index.php?vue=Equipe&action=visualiser>Visualiser les équipes</a></li>
					<li><a class="dropdown-item" href=index.php?vue=Equipe&action=visualiserParSpecialites>Visualiser les équipes par specialités</a></li>
				</ul>
			</div>
			<div class="dropdown col">
				<button class="btn bg-transparent dropdown-toogle" type="button" id="menuAdherent" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Menu Adherent 
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="menuAdherent">
					<li><a class="dropdown-item" href=index.php?vue=Adherent&action=visualiser>Visualiser les Adherents</a></li>
				</ul>
			</div>
			<div class="dropdown col">
				<button class="btn bg-transparent dropdown-toogle" type="button" id="contact" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Contact 
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="messages">
					<li><a class="dropdown-item" href=index.php?vue=Connexion&action=contact>écrire un message</a></li>
				</ul>
			</div>
			</div>	
			</div>
		<div class="container">
			<div class="row">
				<div class ="col-md-2 col-xs-12 infosComplementaires">';
					require "vues/ihm/connexion.php";
					require "vues/ihm/deconnexion.php";
					
					
						
						
		}
			
		
		public function afficheMenuAdherent()
		{
			echo '<div class="dropdown col">
				<button class="btn bg-transparent dropdown-toogle" type="button" id="menuAdherent" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Mon profil 
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="menuAdherent">
					<li><a class="dropdown-item" href=index.php?vue=Adherent&action=modifierSonProfil>Modifier son profil</a></li>
					<li><a class="dropdown-item" href=index.php?vue=Adherent&action=informationsProfil>Informations profil</a></li>
					<li><a class="dropdown-item" href=index.php?vue=Adherent&action=coequipier>Mes Coéquipiers</a></li>
				</ul>
			</div>
			<div class="dropdown col">
				<button class="btn bg-transparent dropdown-toogle" type="button" id="menuAdherent" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Me déplacer 
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="menuAdherent">
					<li><a class="dropdown-item" href=index.php?vue=Adherent&action=voyager>Aller en déplacement</a></li>
				</ul>
			</div>
			
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class ="col-md-2 col-xs-12 infosComplementaires">';
					require "vues/ihm/connexion.php";
					require "vues/ihm/deconnexion.php";
					
				
		}
		public function afficheMenuEntraineur()
		{
			echo '<div class="dropdown col">
				<button class="btn bg-transparent dropdown-toogle" type="button" id="menuEntraineur" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Mon profil 
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="menuEntraineur">
					<li><a class="dropdown-item" href=index.php?vue=Entraineur&action=modifierSonProfil>Modifier son profil</a></li>
					<li><a class="dropdown-item" href=index.php?vue=Entraineur&action=informationsProfil>Informations profil</a></li>
				</ul>
			</div>
			<div class="dropdown col">
				<button class="btn bg-transparent dropdown-toogle" type="button" id="menuEntraineur" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Mes sportifs 
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="menuEntraineur">
					<li><a class="dropdown-item" href=index.php?vue=Entraineur&action=visualiserSesAdherents>Visualiser ses Adherents</a></li>
				</ul>
			</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class ="col-md-2 col-xs-12 infosComplementaires">
					';
					require "vues/ihm/connexion.php";
					require "vues/ihm/deconnexion.php";
					
		}
		
		public function afficheMenuAdmin()
		{
			echo'<div class="dropdown col">
			<button class="btn bg-transparent dropdown-toogle" type="button" id="menuSpecialite" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Menu Specialite 
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" aria-labelledby="menuSpecialite">
				<li><a class="dropdown-item" href=index.php?vue=Specialite&action=ajouter>Ajouter une specialité</a></li>
				<li><a class="dropdown-item" href=index.php?vue=Specialite&action=modifier>Modifier une specialité</a></li>
			</ul>
			</div>
			<div class="dropdown col">
				<button class="btn bg-transparent dropdown-toogle" type="button" id="menuEntraineur" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Menu Entraîneur 
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="menuEntraineur">
					<li><a class="dropdown-item" href=index.php?vue=Entraineur&action=ajouter>Ajouter un Entraineur</a></li>
					<li><a class="dropdown-item" href=index.php?vue=Entraineur&action=modifier>Modifier un entraineur</a></li>
					<li><a class="dropdown-item" href=index.php?vue=Entraineur&action=ajouterSpecialite>Ajouter une Spécialité à un Entraineur</a></li>
				</ul>
			</div>
			<div class="dropdown col">
				<button class="btn bg-transparent dropdown-toogle" type="button" id="menuEquipe" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Menu Equipe 
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="menuEquipe">
					<li><a class="dropdown-item" href=index.php?vue=Equipe&action=ajouter>Ajouter une équipe</a></li>
					<li><a class=dropdown-item href=index.php?vue=Equipe&action=modifier>Modifier une équipe</a></li>
				</ul>
			</div>
			<div class="dropdown col">
				<button class="btn bg-transparent dropdown-toogle" type="button" id="menuAdherent" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Menu Adherent 
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="menuAdherent">
					<li><a class="dropdown-item" href=index.php?vue=Adherent&action=ajouter>Ajouter un Adherent</a></li>
					<li><a class="dropdown-item" href=index.php?vue=Adherent&action=modifier>Modifier un Adherent</a></li>
					<li><a class="dropdown-item" href=index.php?vue=Adherent&action=ajouterEquipe>Ajouter une Equipe à un Adherent</a></li>
				</ul>
			</div>
			<div class="dropdown col">
				<button class="btn bg-transparent dropdown-toogle" type="button" id="messages" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
					Gestion Messages 
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" aria-labelledby="messages">
					<li><a class="dropdown-item" href=index.php?vue=Connexion&action=lireMessage>Lire les messages</a></li>
				</ul>
			</div></div>
		</div>
		<div class="container">
			<div class="row">
				<div class ="col-md-2 col-xs-12 infosComplementaires">';
					
					require "vues/ihm/connexion.php";
					require "vues/ihm/deconnexion.php";
					
				
		}
		
		
	}