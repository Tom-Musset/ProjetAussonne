<?php
session_start(['cookie_lifetime' => 43200,'cookie_secure' => true,'cookie_httponly' => true]);
if(!isset($_SESSION['key']))
{
		$_SESSION['key']=bin2hex(random_bytes(32));
}

	class controleur
	{
		private $toutesLesEquipes;
		private $tousLesAdherents;
		private $tousLesVacataires;
		private $tousLesTitulaires;
		private $toutesLesSpecialites;
		private $maBD;
		private $tousLesAdherentsEquipes;
		private $tousLesEntraineursSpecialites;
		
		
/*********************************************************************************************************************
          CONSTRUCTEUR DE NOTRE CONTROLEUR
		       On construit tous les tableux d'objets et on les remplis vec la base de données
*********************************************************************************************************************/
		public function __construct()
		{
			$this->maBD = new accesBD();
			$this->tousLesVacataires = new conteneurVacataire();
			$this->tousLesTitulaires = new conteneurTitulaire();
			$this->toutesLesEquipes = new conteneurEquipe();
			$this->tousLesAdherents = new conteneurAdherent();
			$this->toutesLesSpecialites = new conteneurSpecialite();
			$this->tousLesAdherentsEquipes = new conteneurAdherentEquipe();
			$this->tousLesEntraineursSpecialites = new conteneurEntraineurSpecialite();
			
			$this->chargeLesEntraineursSpecialites();
			$this->chargeLesAdherentsEquipes();
			$this->chargeLesVacataires();
			$this->chargeLesTitulaires();
			$this->chargeLesAdherents();
			$this->chargeLesSpecialites();
			$this->chargeLesEquipes();
			
		}

		

/*****************************************************************************************
           AFFICHAGE DES ENTETES ET PIED DE PAGE
		   
******************************************************************************************/
        public function afficheEntete()
		{
			//appel de la vue de l'entête
			require 'Vues/ihm/entete.php';
		}
		
			
		public function affichePiedPage()
		{
		//appel de la vue du pied de page
		require 'Vues/ihm/piedPage.php';
		}
		
/******************************************************************************************
          EN FONCTION DE LA VUE DEMANDE ON EFFECTUE TELLE OU TELLE ACTION
********************************************************************************************/
		public function affichePage($action,$vue,$role)
		{
			if (isset($_GET['action']) && isset($_GET['vue']))
			{
				$action = htmlspecialchars($_GET['action']);
				$vue = htmlspecialchars($_GET['vue']);

				switch ($vue)
				{
					case "Specialite" : 
						$this->actionSpecialite($action,$role);
						break;
					case "Entraineur" : 
						$this->actionEntraineur($action,$role);
						break;
					case "Equipe" :
						$this->actionEquipe($action,$role);
						break;
					case "Adherent" :
						$this->actionAdherent($action,$role);
						break;
					case "Connexion" :
						$this->actionConnexion($action,$role);
						break;
				}
			}
		}
/************************************************************************************************
              POUR LES ACTIONS CONCERNANT LA CONNEXION
					- Mise en lace d'un menu spécifique pour chacun des roles
*************************************************************************************************/
	
//---> On aiguille notre action
		public function actionConnexion($action,$role)
		{
			switch ($action)
			{
				case "Verification":
					$csrf=hash_hmac('sha256','Clé sécurité connexion.php',$_SESSION['key']); // attention la phrase de sécurité doit être la même qu’au moment de l’affichage dans le formulaire
					if(!empty($_POST['role'])){
						$_SESSION['role'] = htmlspecialchars($_POST['role']);
					}else{
						$vue = new vueCentraleConnexion();
						$vue->AfficherMenuContextuel(4,1);
					}
					$_SESSION['login'] = htmlspecialchars($_POST['login']);
					$_SESSION['pwd']= htmlspecialchars($_POST['pwd']);
					if(hash_equals($csrf,$_POST['csrf']))
					{
						$vue = new vueCentraleConnexion();
						$existe=$this->maBD->verifExistance($_SESSION['role'],$_SESSION['login'],$_SESSION['pwd']);
						// var_dump($existe[0][0]);
						if($existe !== null){
							$vue->AfficherMenuContextuel($_SESSION['role'],$existe[0][0]);
							$_SESSION['key']=bin2hex(random_bytes(32));
						}
						else{
							$vue = new vueCentraleConnexion();
							$vue->AfficherMenuContextuel($_SESSION['role'],0);
						}
					}
					else{
						$vue = new vueCentraleConnexion();
						$vue->AfficherMenuContextuel($_SESSION['role'],0);
					}
					require 'vues/ihm/nouvelle.php';
					break;
				case "initialiserTypeNouvelle":
					echo $ListeDesTypesNouvelles=$this->maBD->listeDesNouvellesFormatHTML();
					break;
				case "typeChoixNouvelle":
					$typeNouvelleChoisi=htmlspecialchars($_GET['typeNouvelle']);
					$vue=new vueCentraleConnexion();
					if (isset($_SESSION['login']))
					{
						$existe=$this->maBD->verifExistance($_SESSION['role'],$_SESSION['login'],$_SESSION['pwd']);
						$vue->AfficherMenuContextuel($_SESSION['role'],$existe[0][0]);
						require 'vues/ihm/nouvelle.php';
					}
					else
					{
						$vue->afficheMenuInternaute();
						require 'vues/ihm/nouvelle.php';
					}
					echo $liste=$this->maBD->listeDesNouvellesPourUnType($typeNouvelleChoisi);
					
					break;
				case "contact":
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuInternaute();
					require 'vues/ihm/contact.php';
					break;
				case "enregMessage":
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuInternaute();
					$emailContact = htmlspecialchars($_POST['emailContact']);
					$messageContact = htmlspecialchars($_POST['messageContact']);
					$this->maBD->enregMessage($emailContact,$messageContact);
					require 'vues/ihm/actionOk.php';
					break;
				case "lireMessage":
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuAdmin();
					require 'vues/ihm/nouvelle.php';
					$message = $this->maBD->listeDesMessages();
					echo $message;
					break;
				case "Deconnexion" :
					$_SESSION = array();
					session_destroy();
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuInternaute();
					require 'vues/ihm/nouvelle.php';
					break;
				
			}
			
		}		
/************************************************************************************************
              POUR LES ACTIONS CONCERNANT LES ENTRAINEURS
					- ajouter un entraineur
					- enregistrer un entraineur
					- visualiser un entraineur
					- modifier un entraineur
*************************************************************************************************/
	
//---> On aiguille notre action
public function actionSpecialite($action,$role)
{
	switch ($action)
	{
		case "visualiser" :
			$vue=new vueCentraleConnexion();
			$vue->afficheMenuInternaute();
			require 'vues/ihm/nouvelle.php';
			$liste=$this->toutesLesSpecialites->listeDesSpecialites();
			$vue = new vueCentraleSpecialite();
			$vue->VisualiserSpecialite($liste);

		break;
		case "ajouter":
			$vue=new vueCentraleConnexion();
			$vue->afficheMenuAdmin();
			require 'vues/ihm/nouvelle.php';
			$vue = new vueCentraleSpecialite();
			$vue->ajouterSpecialite();	
			break;
		case 'enregistrer':
			$libSpecialite = htmlspecialchars($_POST['libSpecialite']);
			$table = 'specialite';
			$idSpecialite = $this->maBD->donneProchainIdentifiant($table);
			$this->toutesLesSpecialites->ajouterUneSpecialite($idSpecialite,$libSpecialite);
			$this->maBD->insertSpecialite($libSpecialite);			
			$vue=new vueCentraleConnexion();
			$vue->afficheMenuAdmin();
			require 'vues/ihm/nouvelle.php';
			break;
		case "modifier" :
			$vue=new vueCentraleConnexion();
			$vue->afficheMenuAdmin();
			require 'vues/ihm/nouvelle.php';
			$message = $this->toutesLesSpecialites->lesSpecialitesAuFormatHTML();
			$vue = new vueCentraleSpecialite();
			$vue->modifierSpecialite($message);
			break;
		case "choixFaitPourModif":
			$vue=new vueCentraleConnexion();
			$vue->afficheMenuAdmin();
			require 'vues/ihm/nouvelle.php';
			$choix=htmlspecialchars($_GET['idSpecialite']);
			$laSpecialite=$this->toutesLesSpecialites->donneObjetSpecialiteDepuisNumero($choix);
			$vue = new vueCentraleSpecialite();
			$vue->choixFaitPourModifSpecialite($laSpecialite->getLibSpecialite(), $choix);	
			break;
		case "EnregModif":
			$vue=new vueCentraleConnexion();
			$vue->afficheMenuAdmin();
			require 'vues/ihm/nouvelle.php';
			$idSpecialite=htmlspecialchars($_GET['idSpecialite']);
			$libSpecialite=htmlspecialchars($_GET['libSpecialite']);
			$this->maBD->modifSpecialite($idSpecialite,$libSpecialite);
			$this->toutesLesSpecialites->modifierUneSpecialite($idSpecialite, $libSpecialite);
			break;
	}
}
		public function actionEntraineur($action,$role)
		{
			switch ($action)
			{
				case "ajouterSpecialite":
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuAdmin();
					require 'vues/ihm/nouvelle.php';
					$vue = new vueCentraleEntraineur();
					$message= $this->toutesLesSpecialites->lesSpecialitesAuFormatHTML();
					$message2 = $this->tousLesTitulaires->listeDesTitulairesNomId();
					$message2 += $this->tousLesVacataires->listeDesVacatairesNomId();
					$vue->ajouterSpecialiteEntraineur($message,$message2);
					break;
				case "enregistrerSpecialite":
					$idSpecialite = htmlspecialchars($_POST['idSpecialite']);
					$idEntraineur = htmlspecialchars($_POST['idEntraineur']);
					$this->maBD->ajouterSpecialiteEntraineur($idSpecialite,$idEntraineur);
					$this->tousLesEntraineursSpecialites->ajouterUnEntraineurSpecialite($idEntraineur, $idSpecialite);
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuAdmin();
					require 'vues/ihm/nouvelle.php';
					break;
				case "ajouter":
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuAdmin();
					require 'vues/ihm/nouvelle.php';
					$vue = new vueCentraleEntraineur();
					$vue->ajouterEntraineur();	
				break;
				case 'SaisirEntraineur':
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuAdmin();
					require 'vues/ihm/nouvelle.php';
					$typeEntraineur = htmlspecialchars($_POST['typeEntraineur']);
					$vue = new vueCentraleEntraineur();
					$vue->saisirEntraineur();
					break;
				case 'enregistrer':
					$typeEntraineur = htmlspecialchars($_POST['typeEntraineur']);
					$telEntraineur = null;
					$nomEntraineur=null;
					if ($typeEntraineur == "Vacataire") {
						$nomEntraineur = htmlspecialchars($_POST['nomEntraineur']);
						$loginEntraineur = htmlspecialchars($_POST['loginEntraineur']);
						$pwdEntraineur = htmlspecialchars($_POST['pwdEntraineur']);
						$telEntraineur = htmlspecialchars($_POST['numTelVacataire']);
						$this->tousLesVacataires->ajouterUnVacataire($this->maBD->donneProchainIdentifiant("ENTRAINEUR")+1, $nomEntraineur, $loginEntraineur,$pwdEntraineur,$telEntraineur);
						$this->maBD->insertVacataire($nomEntraineur,$loginEntraineur,$pwdEntraineur,$telEntraineur);
						$vue=new vueCentraleConnexion();
						$vue->afficheMenuAdmin();
						require 'vues/ihm/nouvelle.php';
					}
					else
					{	$nomEntraineur = htmlspecialchars($_POST['nomEntraineur']);
						$loginEntraineur = htmlspecialchars($_POST['loginEntraineur']);
						$pwdEntraineur = htmlspecialchars($_POST['pwdEntraineur']);
						$dateEmbEntraineur = htmlspecialchars($_POST['dateEmbaucheTitulaire']);
						$this->tousLesTitulaires->ajouterUnTitulaire($this->maBD->donneProchainIdentifiant("ENTRAINEUR")+1, $nomEntraineur,  $loginEntraineur,$pwdEntraineur,$dateEmbEntraineur);
						$this->maBD->insertTitulaire($nomEntraineur, $loginEntraineur,$pwdEntraineur,$dateEmbEntraineur);
						$vue=new vueCentraleConnexion();
						$vue->afficheMenuAdmin();
						require 'vues/ihm/nouvelle.php';
					}
					break;
					case "visualiser" :
						$vue=new vueCentraleConnexion();
						$vue->afficheMenuInternaute();
						require 'vues/ihm/nouvelle.php';
						$EntraineurSpecialite=$this->tousLesEntraineursSpecialites->getLesEntraineursSpecialites();
						$lesTitulaires=$this->tousLesTitulaires->getLesTitulaires();
						$lesVacataires=$this->tousLesVacataires->getLesVacataires();
						$lesEquipes=$this->toutesLesEquipes->getLesEquipes();
						$listeSpecialite=$this->toutesLesSpecialites->getLesSpecialites();
						$vue = new vueCentraleEntraineur();
						$vue->VisualiserEntraineur($lesTitulaires,$lesVacataires,$EntraineurSpecialite,$listeSpecialite,$lesEquipes);
					break;
				case "modifier" :
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuAdmin();
					require 'vues/ihm/nouvelle.php';
					$message = $this->tousLesTitulaires->listeDesTitulairesNomId();
					$message2 = $this->tousLesVacataires->listeDesVacatairesNomId();
					$message+=$message2;
					$vue = new vueCentraleEntraineur();
					$vue->modifierEntraineur($message);
					break;
				case "visualiserSesAdherents" :
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuEntraineur();
					require 'vues/ihm/nouvelle.php';
					$id=$this->maBD->getId($_SESSION['role'],$_SESSION['login'],$_SESSION['pwd']);
					foreach($id as $item){
						$idSession=$item[0];
					}
					$lEntraineur=$this->tousLesTitulaires->donneObjetTitulaireDepuisNumero($idSession);
					$type_Entraineur="Titulaire";
					if ($lEntraineur==NULL){
						$type_Entraineur="Vacataire";
						$lEntraineur=$this->tousLesVacataires->donneObjetVacataireDepuisNumero($idSession);
					}
					$idEntraineur = $lEntraineur->getIdEntraineur();
					$idAdherents = $this->maBD->listeDesAdherents($idEntraineur);
					$lesAdherents = $this->tousLesAdherents->getLesAdherents();
					$vue = new vueCentraleEntraineur();
					$vue->visualiserAdherentDeLentraineur($lesAdherents,$idAdherents);
					break;
				case "choixFaitPourModif" :
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuEntraineur();
					require 'vues/ihm/nouvelle.php';
					$choix=htmlspecialchars($_GET['idEntraineur']);
					$lEntraineur=$this->tousLesTitulaires->donneObjetTitulaireDepuisNumero($choix);
					$type_Entraineur="Titulaire";
					if ($lEntraineur==NULL){
						$type_Entraineur="Vacataire";
						$lEntraineur=$this->tousLesVacataires->donneObjetVacataireDepuisNumero($choix);
					}
					$vue = new vueCentraleEntraineur();
					if($type_Entraineur=="Vacataire"){
						$vue->choixFaitPourModifEntraineur($lEntraineur->getNomEntraineur(),$lEntraineur->getLoginEntraineur(),$lEntraineur->getPwdEntraineur(),$choix,$type_Entraineur,$lEntraineur->getTelephone());	
					}
					else{
						$vue->choixFaitPourModifEntraineur($lEntraineur->getNomEntraineur(),$lEntraineur->getLoginEntraineur(),$lEntraineur->getPwdEntraineur(),$choix,$type_Entraineur,$lEntraineur->getDateEmbauche());	
					}
					break;
				case "EnregModif":
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuAdmin();
					require 'vues/ihm/nouvelle.php';
					$nomEntraineur=htmlspecialchars($_GET['nomEntraineur']);
					$loginEntraineur=htmlspecialchars($_GET['loginEntraineur']);
					$pwdEntraineur=htmlspecialchars($_GET['pwdEntraineur']);
					$idEntraineur=htmlspecialchars($_GET['idEntraineur']);
					$infoEntraineur=htmlspecialchars($_GET['infoEntraineur']);
					$type_Entraineur=htmlspecialchars($_GET['typeEntraineur']);
					$this->maBD->modifEntraineur($idEntraineur,$nomEntraineur,$loginEntraineur,$pwdEntraineur);
					if($type_Entraineur=="Titulaire"){
						$this->tousLesTitulaires->modifierUnTitulaire($idEntraineur, $nomEntraineur, $loginEntraineur, $pwdEntraineur, $infoEntraineur);
						$this->maBD->modifTitulaire($idEntraineur,$infoEntraineur);
					}
					else{
						$this->tousLesVacataires->modifierUnVacataire($idEntraineur, $nomEntraineur, $loginEntraineur, $pwdEntraineur, $infoEntraineur);
						$this->maBD->modifVacataire($idEntraineur,$infoEntraineur);
					}
					break;
				case "modifierSonProfil" :
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuEntraineur();
					require 'vues/ihm/nouvelle.php';
					$id=$this->maBD->getId($_SESSION['role'],$_SESSION['login'],$_SESSION['pwd']);
					foreach($id as $item ){
						$idSession=$item[0];
					}
					$vue = new vueCentraleEntraineur();
					$vue->modifierSonProfil($idSession);
					break;
				case "modifierPwd" :
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuEntraineur();
					require 'vues/ihm/nouvelle.php';
					
					$mdp = htmlspecialchars($_POST['pwdEntraineur']);
					$id = htmlspecialchars($_POST['idEntraineur']);
					$lEntraineur=$this->tousLesTitulaires->donneObjetTitulaireDepuisNumero($id);
					if ($lEntraineur==NULL){
						if (preg_match("#^\S*(?=\S{12,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$#",$mdp))
							{
								echo 'Le changement a eu lieu correctement';
								$objet = $this->tousLesVacataires->donneObjetVacataireDepuisNumero($id);
								$objet->setPwdEntraineur($mdp);
								$this->maBD->modifPwdEntraineur($mdp,$id);
								break;
							}
						else
							{
							echo 'Le mot de passe ne repond pas aux règles exigées';
							echo '	'.$mdp;
								$vue = new vueCentraleVacataire();
								$vue->modifierSonProfil($id);	
								break;					
							}
					}
					else {
						if (preg_match("#^\S*(?=\S{12,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$#",$mdp))
							{
								echo 'Le changement a eu lieu correctement';
								$objet = $this->tousLesTitulaires->donneObjetTitulaireDepuisNumero($id);
								$objet->setPwdEntraineur($mdp);
								$this->maBD->modifPwdEntraineur($mdp,$id);
								break;
							}
						else
							{
							echo 'Le mot de passe ne repond pas aux règles exigées';
							echo '	'.$mdp;
								$vue = new vueCentraleTitulaire();
								$vue->modifierSonProfil($id);	
								break;					
							}
					}
				case "informationsProfil" :
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuEntraineur();
					require 'vues/ihm/nouvelle.php';
					$id=$this->maBD->getId($_SESSION['role'],$_SESSION['login'],$_SESSION['pwd']);
					foreach($id as $item){
						$idSession=$item[0];
					}
					$lEntraineur=$this->tousLesTitulaires->donneObjetTitulaireDepuisNumero($idSession);
					$type_Entraineur="Titulaire";
					if ($lEntraineur==NULL){
						$type_Entraineur="Vacataire";
						$lEntraineur=$this->tousLesVacataires->donneObjetVacataireDepuisNumero($idSession);
					}
					$vue = new vueCentraleEntraineur();
					$listeEntraineur=explode("|",$lEntraineur->afficheEntraineur());
					// var_dump($listeEntraineur);
					echo'<div class="card" style="width: 18rem;margin: auto;">
						<img src="..." class="card-img-top" alt="...">
							<div class="card-body">
								<h5 class="card-title">'.$listeEntraineur[1].'</h5>
								<p class ="card-text">Login : '.$listeEntraineur[2].'</p>
							</div>
						</div>';
					break;
			}
		}
		
// On a une fonction outil de chargement de notre conteneur
		public function chargeLesVacataires()
		{   $resultatEntraineur=$this->maBD->chargement('entraineur');
			$resultatVacataire=$this->maBD->chargement('vacataire');
			$nbE=0;
			while ($nbE<sizeof($resultatEntraineur))
			{
				$nbV=0;
				while ($nbV<sizeof($resultatVacataire))
				{
					if ($resultatEntraineur[$nbE][0] == $resultatVacataire[$nbV][0])
					{
						$this->tousLesVacataires->ajouterUnVacataire($resultatEntraineur[$nbE][0],$resultatEntraineur[$nbE][1],$resultatEntraineur[$nbE][2],$resultatEntraineur[$nbE][3],$resultatVacataire[$nbV][1]);
					}
					$nbV++;
				}
				$nbE++;
			}
			
		}
	
		public function chargeLesTitulaires()
		{   $resultatEntraineur=$this->maBD->chargement('entraineur');
			$resultatTitulaire=$this->maBD->chargement('titulaire');
			$nbE=0;
			while ($nbE<sizeof($resultatEntraineur))
			{
				$nbT=0;
				while ($nbT<sizeof($resultatTitulaire))
				{
					if ($resultatEntraineur[$nbE][0] == $resultatTitulaire[$nbT][0])
					{
						$this->tousLesTitulaires->ajouterUnTitulaire($resultatEntraineur[$nbE][0],$resultatEntraineur[$nbE][1],$resultatEntraineur[$nbE][2],$resultatEntraineur[$nbE][2],$resultatTitulaire[$nbT][1]);
					}
					$nbT++;
				}
				$nbE++;
			}
			
		}

/************************************************************************************************
              POUR LES ACTIONS CONCERNANT LES EQUIPES
					- ajouter une équipe
					- enregistrer une équipe
					- visualiser une équipe
					- modifier une équipe
*************************************************************************************************/
	
//---> On aiguille notre action
	
		function actionEquipe($action,$role)
		{
			switch ($action)
			{
				
				
				case "ajouter":
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuAdmin();//J'ajoute une nouvelle équipe juste pour voir si cela fonctionne
					require 'vues/ihm/nouvelle.php';
					$vue = new vueCentraleEquipe();
					$message = $this->tousLesTitulaires->listeDesTitulairesNomId();
					$message2 = $this->tousLesVacataires->listeDesVacatairesNomId();
					$message+=$message2;
					$specialite = $this->toutesLesSpecialites->listeDesSpecialitesLibId();
					$vue->ajouterEquipe($message, $specialite);
					// mais la fonctionnalité reste à faire en réalité
					// $this->toutesLesEquipes->ajouterUneEquipe($this->maBD->donneNumeroMaxEquipe(),'equipe essai',10,5,8,'F',$this->tousLesTitulaires->donneObjetTitulaireDepuisNumero(1));
					// $this->maBD->insertEquipe('equipe essai',10,5,8,'F',1);			
					break;
				case "enregistrer":
					$NomEquipe = htmlspecialchars($_POST['NomEquipe']);
					$nbrPlaceEquipe = htmlspecialchars($_POST['nbrPlaceEquipe']);
					$ageMinEquipe = htmlspecialchars($_POST['ageMinEquipe']);
					$ageMaxEquipe = htmlspecialchars($_POST['ageMaxEquipe']);
					$sexeEquipe = htmlspecialchars($_POST['sexeEquipe']);
					$entraineurEquipe = htmlspecialchars($_POST['entraineurEquipe']);
					$entraineurSpecialite = htmlspecialchars($_POST['specialiteEquipe']);					$entraineurEquipe= intval($entraineurEquipe);
					$entraineur=$this->tousLesTitulaires->donneObjetTitulaireDepuisNumero($entraineurEquipe);
					if ($entraineur==NULL){
						$entraineur=$this->tousLesVacataires->donneObjetVacataireDepuisNumero($entraineurEquipe);
					}
					$this->toutesLesEquipes->ajouterUneEquipe($this->maBD->donneNumeroMaxEquipe(),$NomEquipe,$nbrPlaceEquipe,$ageMinEquipe,$ageMaxEquipe,$sexeEquipe,$entraineur,$entraineurSpecialite);
					$this->maBD->insertEquipe($NomEquipe,$nbrPlaceEquipe,$ageMinEquipe,$ageMaxEquipe,$sexeEquipe,$entraineurEquipe,$entraineurSpecialite);			
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuAdmin();
					require 'vues/ihm/nouvelle.php';
				break;
				case "visualiser" :
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuInternaute();
					require 'vues/ihm/nouvelle.php';
					$message = $this->toutesLesEquipes->listeDesEquipes();
					$vue = new vueCentraleEquipe();
					$vue->visualiserEquipe($message);
					break;
				case "visualiserParSpecialites" :
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuInternaute();
					require 'vues/ihm/nouvelle.php';
					$message = $this->toutesLesEquipes->getLesEquipes();
					$message2 = $this->toutesLesSpecialites->getLesSpecialites();
					$vue = new vueCentraleEquipe();
					$vue->visualiserEquipeParSpecialite($message, $message2);
					break;
				case "modifier" :
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuAdmin();
					require 'vues/ihm/nouvelle.php';
					$message= $this->toutesLesEquipes->lesEquipesAuFormatHTML();
					$vue = new vueCentraleEquipe();
					$vue->modifierEquipe($message);
					break;
				case "choixFaitPourModif":
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuAdmin();
					require 'vues/ihm/nouvelle.php';
					$choix=htmlspecialchars($_GET['idEquipe']);
					$lEquipe=$this->toutesLesEquipes->donneObjetEquipeDepuisNumero($choix);
					$vue = new vueCentraleEquipe();
					$vue->choixFaitPourModifEquipe($lEquipe->getNomEquipe(),$lEquipe->getNbrPlaceEquipe(),$lEquipe->getAgeMinEquipe(),$lEquipe->getAgeMaxEquipe(),$lEquipe->getSexeEquipe(),$choix,$this->tousLesTitulaires->lesTitulairesAuFormatHTML(), $this->toutesLesSpecialites->lesSpecialitesAuFormatHTML());	
					break;
				case "EnregModif":
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuAdmin();
					require 'vues/ihm/nouvelle.php';
					$idEquipe=htmlspecialchars($_GET['idEquipe']);
					$nomEquipe=htmlspecialchars($_GET['nomEquipe']);
					$nbrPlaceEquipe=htmlspecialchars($_GET['nbrPlaceEquipe']);
					$ageMinEquipe=htmlspecialchars($_GET['ageMinEquipe']);
					$ageMaxEquipe=htmlspecialchars($_GET['ageMaxEquipe']);
					$sexeEquipe=htmlspecialchars($_GET['sexeEquipe']);
					$idTitulaire = htmlspecialchars($_GET['idTitulaire']);
					$leTitulaire = $this->tousLesTitulaires->donneObjetTitulaireDepuisNumero($idTitulaire);
					$idSpecialite = htmlspecialchars($_GET['idSpecialite']);
					$laSpecialite = $this->toutesLesSpecialites->donneObjetSpecialiteDepuisNumero($idSpecialite);
					$this->maBD->modifEquipe($idEquipe,$nomEquipe,$nbrPlaceEquipe,$ageMinEquipe,$ageMaxEquipe,$sexeEquipe,$idTitulaire, $idSpecialite);
					$this->toutesLesEquipes->modifierUneEquipe($idEquipe, $nomEquipe, $nbrPlaceEquipe, $ageMinEquipe, $ageMaxEquipe, $sexeEquipe, $leTitulaire, $laSpecialite);
					break;
			}
		}
		
// On a une fonction outil de chargement de notre conteneur	

		public function chargeLesEquipes()
		{   $resultatEquipe=$this->maBD->chargement('equipe');
			$nbE=0;
			while ($nbE<sizeof($resultatEquipe))
			{
				
				if ($this->tousLesVacataires->chercherExistanceIdVacataire($resultatEquipe[$nbE][6]))
				{
					
						$this->toutesLesEquipes->ajouterUneEquipe($resultatEquipe[$nbE][0],$resultatEquipe[$nbE][1],$resultatEquipe[$nbE][2],$resultatEquipe[$nbE][3],$resultatEquipe[$nbE][4],$resultatEquipe[$nbE][5],$this->tousLesVacataires->donneObjetVacataireDepuisNumero($resultatEquipe[$nbE][6]), $this->toutesLesSpecialites->donneObjetSpecialiteDepuisNumero($resultatEquipe[$nbE][7]));
				}
				else
				{		$this->toutesLesEquipes->ajouterUneEquipe($resultatEquipe[$nbE][0],$resultatEquipe[$nbE][1],$resultatEquipe[$nbE][2],$resultatEquipe[$nbE][3],$resultatEquipe[$nbE][4],				$resultatEquipe[$nbE][5],$this->tousLesTitulaires->donneObjetTitulaireDepuisNumero($resultatEquipe[$nbE][6]),  $this->toutesLesSpecialites->donneObjetSpecialiteDepuisNumero($resultatEquipe[$nbE][7]));
					
				}
				$nbE++;
			}
		
		}


/************************************************************************************************
              POUR LES ACTIONS CONCERNANT LES ADHERENTS
					- ajouter un adherent
					- enregistrer un adherent
					- visualiser un adherent
					- modifier un adherent
*************************************************************************************************/
//---> On aiguille notre action		
		function actionAdherent($action,$role)
		{
			switch ($action)
			{
				case "ajouterEquipe":
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuAdmin();
					require 'vues/ihm/nouvelle.php';
					$vue = new vueCentraleAdherent();
					$message= $this->toutesLesEquipes->lesEquipesAuFormatHTML();
					$message2= $this->tousLesAdherents->lesAdherentsAuFormatHTML();
					$vue->ajouterEquipeAdherent($message,$message2);
					break;
				case "enregistrerEquipe":
					$idEquipe = htmlspecialchars($_POST['idEquipe']);
					$idAdherent = htmlspecialchars($_POST['idAdherent']);
					$this->maBD->ajouterEquipeAdherent($idAdherent,$idEquipe);
					$this->tousLesAdherentsEquipes->ajouterUnAdherentEquipe($idAdherent, $idEquipe);
					$vue=new vueCentraleConnexion();
						$vue->afficheMenuAdmin();
						require 'vues/ihm/nouvelle.php';
				break;
				case "ajouter":
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuAdmin();
					require 'vues/ihm/nouvelle.php';
					$vue = new vueCentraleAdherent();
					$vue->ajouterAdherent();
					break;
				case "enregistrer":
					$Nom = htmlspecialchars($_POST['Nom']);
					$Prenom = htmlspecialchars($_POST['Prenom']);
					$Age = htmlspecialchars($_POST['Age']);
					$Sexe = htmlspecialchars($_POST['Sexe']);
					$Login = htmlspecialchars($_POST['Login']);
					$Password = htmlspecialchars($_POST['Password']);
				$this->tousLesAdherents->ajouterUnAdherent($this->maBD->donneNumeroMaxEquipe(),$Nom,$Prenom,$Age,$Sexe,$Login,$Password);
				$this->maBD->insertAdherent($Nom,$Prenom,$Age,$Sexe,$Login,$Password);			
					$vue=new vueCentraleConnexion();
						$vue->afficheMenuAdmin();
						require 'vues/ihm/nouvelle.php';
				break;
				case "visualiser" :
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuInternaute();
					require 'vues/ihm/nouvelle.php';
					$message = $this->tousLesAdherents->listeDesAdherents();
					$vue = new vueCentraleAdherent();
					$vue->visualiserAdherent($message);
					break;
				case "modifier" :
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuAdmin();
					require 'vues/ihm/nouvelle.php';
					$message= $this->tousLesAdherents->lesAdherentsAuFormatHTML();
					$vue = new vueCentraleAdherent();
					$vue->modifierAdherent($message);
					break;
				case "choixFaitPourModif" :
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuAdherent();
					require 'vues/ihm/nouvelle.php';
					$choix=htmlspecialchars($_GET['idAdherent']);
					$lAdherent=$this->tousLesAdherents->donneObjetAdherentDepuisNumero($choix);
					$vue = new vueCentraleAdherent();
					$vue->choixFaitPourModifAdherent($lAdherent->getNomAdherent(),$lAdherent->getPrenomAdherent(),$lAdherent->getAgeAdherent(),$lAdherent->getSexeAdherent(),$lAdherent->getLoginAdherent(),$lAdherent->getPwdAdherent(),$choix);	
					break;
				case "EnregModif":
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuAdmin();
					require 'vues/ihm/nouvelle.php';
					$idAdherent=htmlspecialchars($_GET['idAdherent']);
					$nomAdherent=htmlspecialchars($_GET['nomAdherent']);
					$prenomAdherent=htmlspecialchars($_GET['prenomAdherent']);
					$ageAdherent=htmlspecialchars($_GET['ageAdherent']);
					$sexeAdherent=htmlspecialchars($_GET['sexeAdherent']);
					$loginAdherent=htmlspecialchars($_GET['loginAdherent']);
					$pwdAdherent=htmlspecialchars($_GET['pwdAdherent']);
					$this->maBD->modifAdherent($idAdherent,$nomAdherent,$prenomAdherent,$ageAdherent,$sexeAdherent,$loginAdherent,$pwdAdherent);
					$this->tousLesAdherents->modifierUnAdherent($idAdherent, $nomAdherent, $prenomAdherent, $ageAdherent, $sexeAdherent, $loginAdherent, $pwdAdherent);
					break;
				case "voyager" :
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuAdherent();
					$vue = new vueCentraleAdherent();
					require 'vues/ihm/nouvelle.php';
					$vue->voyagerAdherent();
					break;
				case "modifierSonProfil" :
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuAdherent();
					require 'vues/ihm/nouvelle.php';
					$id=$this->maBD->getId($_SESSION['role'],$_SESSION['login'],$_SESSION['pwd']);
					foreach($id as $item ){
						$idSession=$item[0];
					}
					$vue = new vueCentraleAdherent();
					$vue->modifierSonProfil($idSession);
					break;
				case "modifierPwd" :
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuAdherent();
					require 'vues/ihm/nouvelle.php';
					$mdp = htmlspecialchars($_POST['pwdAdherent']);
					$id = htmlspecialchars($_POST['idAdherent']);
					if (preg_match("#^\S*(?=\S{12,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$#",$mdp))
					{
								echo 'Le changement a eu lieu correctement';
								$objet = $this->tousLesAdherents->donneObjetAdherentDepuisNumero($id);
								$objet->setPwdAdherent($mdp);
								$this->maBD->modifPwdAdherent($mdp,$id);
								break;
					}
					else
					{
							echo 'Le mot de passe ne repond pas aux règles exigées';
								$vue = new vueCentraleAdherent();
								$vue->modifierSonProfil($id);	
								break;					
					}
				case "informationsProfil" :
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuAdherent();
					require 'vues/ihm/nouvelle.php';
					$id=$this->maBD->getId($_SESSION['role'],$_SESSION['login'],$_SESSION['pwd']);
					foreach($id as $item){
						$idSession=$item[0];
					}
					$lAdherent=$this->tousLesAdherents->donneObjetAdherentDepuisNumero($idSession);
					$vue = new vueCentraleAdherent();
					$listeAdherent=explode("|",$lAdherent->afficheAdherent());
					echo'<div class="card" style="width: 18rem;margin: auto;">
						<img src="..." class="card-img-top" alt="...">
							<div class="card-body">
								<h5 class="card-title">'.$listeAdherent[0].' '.$listeAdherent[1].'</h5>
								<p class="card-text">Age : '.$listeAdherent[2].'<br>Sexe :'.$listeAdherent[3].'<br>Login : '.$listeAdherent[4].'<br>Equipe : '.$listeAdherent[5].'</p>
							</div>
						</div>';
					break;
				case "coequipier";
					$vue=new vueCentraleConnexion();
					$vue->afficheMenuAdherent();
					require 'vues/ihm/nouvelle.php';
					$id=$this->maBD->getId($_SESSION['role'],$_SESSION['login'],$_SESSION['pwd']);
					foreach($id as $item){
						$idSession=$item[0];
					}
					$lAdherent=$this->tousLesAdherents->donneObjetAdherentDepuisNumero($idSession);
					$id=$this->maBD->listeDesCoequipier($lAdherent->getIdAdherent());
					$lesAdherents=$this->tousLesAdherents->getLesAdherents();
					$vue = new vueCentraleAdherent();
					$vue->visualiserCoéquipier($lesAdherents,$id);
					break;
			}
		}

// On a une fonction outil de chargement de notre conteneur	
	
		public function chargeLesAdherents()
		{   $resultatAdherent=$this->maBD->chargement('adherent');
			$nbA=0;
			while ($nbA<sizeof($resultatAdherent))
			{	$this->tousLesAdherents->ajouterUnAdherent($resultatAdherent[$nbA][0],$resultatAdherent[$nbA][1],$resultatAdherent[$nbA][2],$resultatAdherent[$nbA][3],$resultatAdherent[$nbA][4],$resultatAdherent[$nbA][5],$resultatAdherent[$nbA][6]);
				$nbA++;
			}
			
		}	

		public function chargeLesSpecialites()
		{   $resultatSpecialite=$this->maBD->chargement('specialite');


			$nbA=0;
			while ($nbA<sizeof($resultatSpecialite))
			{	$this->toutesLesSpecialites->ajouterUneSpecialite($resultatSpecialite[$nbA][0],$resultatSpecialite[$nbA][1]);
				$nbA++;
			}
			
		}	
		public function chargeLesAdherentsEquipes()
		{   $resultatSpecialite=$this->maBD->chargement('AdherentEquipe');


			$nbA=0;
			while ($nbA<sizeof($resultatSpecialite))
			{	$this->tousLesAdherentsEquipes->ajouterUnAdherentEquipe($resultatSpecialite[$nbA][0],$resultatSpecialite[$nbA][1]);
				$nbA++;
			}
			
		}	

		public function chargeLesEntraineursSpecialites()
		{   $resultatSpecialite=$this->maBD->chargement('EntraineurSpecialite');


			$nbA=0;
			while ($nbA<sizeof($resultatSpecialite))
			{	$this->tousLesEntraineursSpecialites->ajouterUnEntraineurSpecialite($resultatSpecialite[$nbA][0],$resultatSpecialite[$nbA][1]);
				$nbA++;
			}
			
		}
	}
?>