<?php

class accesBD
{
	private $hote;
	private $login;
	private $passwd;
	private $base;
	private $conn;
	
	// Nous construisons notre connexion
	public function __construct()
		{
		$this->hote="localhost";
		$this->login="root";
		$this->passwd="";
		$this->base="clubAussonne";
		$this->connexion();
		
		}
	private function connexion()
	{
		try
        {
            $this->conn = new PDO("mysql:host=".$this->hote.";dbname=".$this->base.";charset=utf8", $this->login, $this->passwd);
            $this->boolConnexion = true;
        }
        catch(PDOException $e)
        {
            die("Connection à la base de données échouée".$e->getMessage());
        }
	}
	
	public function verifExistance($role,$login,$pwd)
	{   
	
		switch ($role)
		{
			case "1" :
				$requete=$this->conn->prepare("SELECT idAdmin FROM administrateur where loginAdmin = ? and pwdAdmin = ? ;");
				
				$requete->bindValue(1,$login);
				$requete->bindValue(2,$pwd);
				
				$lesInfos=null;
				$nbTuples=0;

				if($requete->execute())
				{
					while($row = $requete->fetch(PDO::FETCH_NUM))
					{
						$lesInfos[$nbTuples] = $row;
						$nbTuples++;
					}
				}
				return $lesInfos;

				break;
			case "2" :
				$requete=$this->conn->prepare("SELECT idAdherent FROM adherent where loginAdherent = ? and pwdAdherent = ? ;");
				
				$requete->bindValue(1,$login);
				$requete->bindValue(2,$pwd);

				$lesInfos=null;
				$nbTuples=0;

				if($requete->execute())
				{
					while($row = $requete->fetch(PDO::FETCH_NUM))
					{
						$lesInfos[$nbTuples] = $row;
						$nbTuples++;
					}
				}
				return $lesInfos;
				
				break;
			case "3" :
				$requete=$this->conn->prepare("SELECT idEntraineur FROM entraineur where loginEntraineur = ? and pwdEntraineur = ? ;");
				
				$requete->bindValue(1,$login);
				$requete->bindValue(2,$pwd);
				
				$lesInfos=null;
				$nbTuples=0;

				if($requete->execute())
				{
					while($row = $requete->fetch(PDO::FETCH_NUM))
					{
						$lesInfos[$nbTuples] = $row;
						$nbTuples++;
					}
				}
				return $lesInfos;
				
				break;
		}
		
		// $result=$this->conn->query($requete);
		
		// if ($result)
    	// {
		// 	if ($result->rowCount()==1)
		// 	{
		// 		return(1);
		// 	}
		// 	else
		// 	{
		// 		return(0);
		// 	}
		// }
	}

	public function modifPwdAdherent($mdp,$id){
		$requete=$this->conn->prepare("UPDATE adherent set pwdAdherent = ?  WHERE idAdherent = ? ; ");

		$requete->bindValue(1,$mdp);
		$requete->bindValue(2,$id);
		
		$requete->execute();
	}

	public function modifPwdEntraineur($mdp,$id){
		$requete=$this->conn->prepare("UPDATE entraineur set pwdEntraineur = ?  WHERE idEntraineur = ? ; ");

		$requete->bindValue(1,$mdp);
		$requete->bindValue(2,$id);
		
		$requete->execute();
	}
	
	public function getId($role,$login,$pwd)
	{   
	
		switch ($role)
		{
			case "1" :
				$requete=$this->conn->prepare("SELECT idAdmin FROM administrateur where loginAdmin = ? and pwdAdmin = ? ;");
				
				$requete->bindValue(1,$login);
				$requete->bindValue(2,$pwd);

				break;
			case "2" :
				$requete=$this->conn->prepare("SELECT idAdherent FROM adherent where loginAdherent = ? and pwdAdherent = ? ;");
				
				$requete->bindValue(1,$login);
				$requete->bindValue(2,$pwd);
				
				break;
			case "3" :
				$requete=$this->conn->prepare("SELECT idEntraineur FROM entraineur where loginEntraineur = ? and pwdEntraineur = ? ;");
				
				$requete->bindValue(1,$login);
				$requete->bindValue(2,$pwd);
				break;
		}
		
			$lesInfos=null;
			$nbTuples=0;

			if($requete->execute())
			{
				while($row = $requete->fetch(PDO::FETCH_NUM))
				{
					$lesInfos[$nbTuples] = $row;
					$nbTuples++;
				}
				return $lesInfos;
			}
			else
			{
				return(0);
			}
	}
	
	public function enregMessage($emailContact,$messageContact)
	{   

		$requete = $this->conn->prepare("INSERT INTO message (emailContact, messageContact) VALUES (?,?)");
		$requete->bindValue(1,$emailContact);
		$requete->bindValue(2,$messageContact);
		$requete->execute();
		
		
	}

	public function listeDesMessages()
	{
		$requete='select * from message;';
		$retour = '';
		$result=$this->conn ->query($requete);
		while ( $row = $result->fetch ( PDO::FETCH_OBJ ) )
		{
			$retour = $retour . $row->idMessage . '|' . $row->emailContact . '|'. $row->messageContact . '<br>';
		};
		
		return $retour;
			
	}		
	
	public function listeDesNouvellesFormatHTML()
	{
		$requete='select * from typeNouvelle;';
		$retour = '<select name=typeNouvelle>';
		$result=$this->conn ->query($requete);
		while ( $row = $result->fetch ( PDO::FETCH_OBJ ) )
		{
			$retour = $retour . '<option value="' . $row->idTypeNouvelle . '">' . $row->libelleTypeNouvelle . '</option>';
		}
		$retour = $retour .'</select>';
		echo $retour;
			
	}	
	
	public function listeDesNouvellesPourUnType($idTypeNouvelleChoisi)
	{
		try{
			$retour="";
			$requete = $this->conn->prepare("SELECT idNouvelle, dateParutionNouvelle, descriptionNouvelle FROM nouvelle where idTypeNouvelle =  ?");
			$requete->bindValue(1,$idTypeNouvelleChoisi);

			if($requete->execute())
				{
					while ( $row = $requete->fetch(PDO::FETCH_OBJ ) )
					{
						$retour = $retour.'|'.$row->idNouvelle.'|'.$row->dateParutionNouvelle.'|'.$row->descriptionNouvelle;
					}
					return $retour;
				}
			
		}
		catch(PDOException $e)
        {
            die("erreur dans la requête".$e->getMessage());
        }
			
	}	

	public function listeDesAdherents($idEntraineur){
		try{
			$retour = array();
			$requete = $this->conn->prepare("SELECT distinct idAdherent 
			FROM equipe e , adherentequipe ae
			WHERE e.idEntraineur = ? 
			AND e.idEquipe = ae.idEquipe ");
			$requete->bindValue(1,$idEntraineur);

			if($requete->execute()){
				while($row = $requete->fetch(PDO::FETCH_OBJ)){
					array_push($retour,$row->idAdherent);
				}
				return $retour;
			}
		}
		catch(PDOException $e){
			die("erreur dans la requête".$e->getMessage());
		}
	}

	public function listeDesCoequipier($idAdherent)
	{
		try{
			$retour=array();
			$requete = $this->conn->prepare("SELECT distinct idAdherent 
			FROM adherentequipe 
			WHERE idEquipe in (select idEquipe from adherentequipe where idAdherent=?)
			and idAdherent != ?");
			$requete->bindValue(1,$idAdherent);
			$requete->bindValue(2,$idAdherent);

			if($requete->execute())
				{
					while ( $row = $requete->fetch(PDO::FETCH_OBJ ) )
					{
						array_push($retour,$row->idAdherent);
					}
					return $retour;
				}
			
		}
		catch(PDOException $e)
        {
            die("erreur dans la requête".$e->getMessage());
        }
			
	}

	
	/******************************************************************************
	Nous avons toutes les fonctions d'insertion
	*******************************************************************************/
	public function insertVacataire($unNomEntraineur,$unLoginEntraineur, $unPwdEntraineur,$unTelephone)
	{
		$sonId = $this->donneProchainIdentifiant("ENTRAINEUR","idEntraineur");
		$requete = $this->conn->prepare("INSERT INTO ENTRAINEUR (idEntraineur,nomEntraineur,loginEntraineur,pwdEntraineur) VALUES (?,?,?,?)");
		$requete->bindValue(1,$sonId);
		$requete->bindValue(2,$unNomEntraineur);
		$requete->bindValue(3,$unLoginEntraineur);
		$requete->bindValue(4,$unPwdEntraineur);
		if(!$requete->execute())
		{
			die("Erreur dans insert Entraineur : ".$requete->errorCode());
		}
		
		$requete = $this->conn->prepare("INSERT INTO vacataire (idEntraineur,telephoneVacataire) VALUES (?,?)");
		$requete->bindValue(1,$sonId);
		$requete->bindValue(2,$unTelephone);
		if(!$requete->execute())
		{
			die("Erreur dans insert Vacataire : ".$requete->errorCode());
		}
		return $sonId;
	}
		
	public function insertTitulaire($unNomEntraineur,$unLoginEntraineur, $unPwdEntraineur,$uneDateEmbauche)
	{
		$sonId = $this->donneProchainIdentifiant("ENTRAINEUR","idEntraineur");
		$requete = $this->conn->prepare("INSERT INTO ENTRAINEUR (idEntraineur,nomEntraineur,loginEntraineur,pwdEntraineur) VALUES (?,?,?,?)");
		$requete->bindValue(1,$sonId);
		$requete->bindValue(2,$unNomEntraineur);
		$requete->bindValue(3,$unLoginEntraineur);
		$requete->bindValue(4,$unPwdEntraineur);
		if(!$requete->execute())
		{
			die("Erreur dans insert Entraineur : ".$requete->errorCode());
		}
		
		$requete = $this->conn->prepare("INSERT INTO titulaire (idEntraineur,dateEmbauche) VALUES (?,?)");
		$requete->bindValue(1,$sonId);
		$requete->bindValue(2,$uneDateEmbauche);
		if(!$requete->execute())
		{
			die("Erreur dans insert Titulaire : ".$requete->errorCode());
		}

		return $sonId;
	}
		
	public function insertEquipe($unNomEquipe,$unNbrPlaceEquipe,$unAgeMinEquipe,$unAgeMaxEquipe,$unSexeEquipe,$unIdEntraineur,$entraineurSpecialite)
	{
		$sonId = $this->donneProchainIdentifiant("EQUIPE","idEquipe");
		$requete = $this->conn->prepare("INSERT INTO EQUIPE (idEquipe,nomEquipe,nbrPlaceEquipe,ageMinEquipe,ageMaxEquipe,sexeEquipe,idEntraineur,idSpecialite) VALUES (?,?,?,?,?,?,?,?)");
		$requete->bindValue(1,$sonId);
		$requete->bindValue(2,$unNomEquipe);
		$requete->bindValue(3,$unNbrPlaceEquipe);
		$requete->bindValue(4,$unAgeMinEquipe);
		$requete->bindValue(5,$unAgeMaxEquipe);
		$requete->bindValue(6,$unSexeEquipe);
		$requete->bindValue(7,$unIdEntraineur);
		$requete->bindValue(8,$entraineurSpecialite);

		if(!$requete->execute())
		{
			die("Erreur dans insert Equipe : ".$requete->errorCode());
		}
		return $sonId;
	}
	public function insertSpecialite($unLibSpecialite)
	{
		$sonId = $this->donneProchainIdentifiant("SPECIALITE","idSpecialite");
		$requete = $this->conn->prepare("INSERT INTO SPECIALITE (idSpecialite,libSpecialite) VALUES (?,?)");
		$requete->bindValue(1,$sonId);
		$requete->bindValue(2,$unLibSpecialite);
		if(!$requete->execute())
		{
			die("Erreur dans insert Equipe : ".$requete->errorCode());
		}
		return $sonId;
	}
	
		
	public function insertAdherent($unNomAdherent,$unPrenomAdherent,$unAgeAdherent, $unSexeAdherent,$unLoginAdherent, $unPwdAdherent)
	{
		$sonId = $this->donneProchainIdentifiant("ADHERENT","idAdherent")+1;
		$requete = $this->conn->prepare("INSERT INTO ADHERENT (idAdherent,nomAdherent, prenomAdherent, ageAdherent, sexeAdherent,loginAdherent, pwdAdherent) VALUES (?,?,?,?,?,?,?)");
		$requete->bindValue(1,$sonId);
		$requete->bindValue(2,$unNomAdherent);
		$requete->bindValue(3,$unPrenomAdherent);
		$requete->bindValue(4,$unAgeAdherent);
		$requete->bindValue(5,$unSexeAdherent);
		$requete->bindValue(6,$unLoginAdherent);
		$requete->bindValue(7,$unPwdAdherent);
		if(!$requete->execute())
		{
			die("Erreur dans insert Adherent : ".$requete->errorCode());
		}
		return $sonId;
	}
	
	/***********************************************************************************************
	méthode qui va permettre de modifier les éléments d'une équipe.
	***********************************************************************************************/
	public function modifEquipe($idEquipe,$unNomEquipe,$unNbrPlaceEquipe,$unAgeMinEquipe,$unAgeMaxEquipe,$unSexeEquipe,$unIdEntraineur,$unIdSpecialite)
	{	$requete = $this->conn->prepare("UPDATE equipe SET nomEquipe = ?, nbrPlaceEquipe = ?, ageMinEquipe = ?, ageMaxEquipe = ?, sexeEquipe = ?, idEntraineur = ?, idSpecialite = ? where idEquipe = ?");
		
		$requete->bindValue(1,$unNomEquipe);
		$requete->bindValue(2,$unNbrPlaceEquipe);
		$requete->bindValue(3,$unAgeMinEquipe);
		$requete->bindValue(4,$unAgeMaxEquipe);
		$requete->bindValue(5,$unSexeEquipe);
		$requete->bindValue(6,$unIdEntraineur);
		$requete->bindValue(7,$unIdSpecialite);
		$requete->bindValue(8,$idEquipe);
		
		echo "La modification est effectuée.";
		
		if(!$requete->execute())
		{
			die("Erreur dans modif Equipe : ".$requete->errorCode());
		}
		return $idEquipe;
	}

	public function ajouterEquipeAdherent($idAdherent,$idEquipe){
		$requete = $this->conn->prepare("INSERT INTO adherentEquipe VALUES(?,?)");
		$requete->bindValue(1,$idAdherent);
		$requete->bindValue(2,$idEquipe);

		if($requete === false){
			echo 'requete is false';
			exit();
		}
		try{
			$result = $requete->execute();
			if($result === false){
				$error = $requete->errorInfo();
				if($error[0]===45000)
				{
					echo "$error[2] ... is the error reported by trigger\n";
				}
				else
				{
					// vrai erreur sql
					echo "$error[2] ... is the error reported by sql\n";
				}
			}else{
				echo "L'ajout est effectué.";
			}
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}	
	}

	public function ajouterSpecialiteEntraineur($idSpecialite,$idEntraineur){
		$requete = $this->conn->prepare("INSERT INTO entraineurspecialite VALUES(?,?)");
		$requete->bindValue(1,$idEntraineur);
		$requete->bindValue(2,$idSpecialite);

		echo "L'ajout est effectué.";
		
		if(!$requete->execute())
		{
			die("Erreur dans modif Equipe : ".$requete->errorCode());
		}
	}

	public function modifAdherent($idAdherent,$nomAdherent,$prenomAdherent,$ageAdherent,$sexeAdherent,$loginAdherent,$pwdAdherent)
	{	$requete = $this->conn->prepare("UPDATE adherent SET nomAdherent = ?, prenomAdherent = ?, ageAdherent = ?, sexeAdherent = ?, loginAdherent = ?, pwdAdherent = ? where idAdherent = ?");
		
		$requete->bindValue(1,$nomAdherent);
		$requete->bindValue(2,$prenomAdherent);
		$requete->bindValue(3,$ageAdherent);
		$requete->bindValue(4,$sexeAdherent);
		$requete->bindValue(5,$loginAdherent);
		$requete->bindValue(6,$pwdAdherent);
		$requete->bindValue(7,$idAdherent);
		
		echo "La modification est effectuée.";
		
		if(!$requete->execute())
		{
			die("Erreur dans modif Equipe : ".$requete->errorCode());
		}
		return $idAdherent;
	}

	public function modifEntraineur($idEntraineur,$unNomEntraineur,$unLoginEntraineur,$unPwdEntraineur)
	{	$requete = $this->conn->prepare("UPDATE entraineur SET nomEntraineur = ?, loginEntraineur = ?, pwdEntraineur = ? where idEntraineur = ?");
		
		$requete->bindValue(1,$unNomEntraineur);
		$requete->bindValue(2,$unLoginEntraineur);
		$requete->bindValue(3,$unPwdEntraineur);
		$requete->bindValue(4,$idEntraineur);
		
		echo "La modification est effectuée.";
		
		if(!$requete->execute())
		{
			die("Erreur dans modif Equipe : ".$requete->errorCode());
		}
		return $idEntraineur;
	}

	public function modifTitulaire($idEntraineur,$uneInfoTitulaire)
	{	$requete = $this->conn->prepare("UPDATE titulaire SET dateEmbauche = ? where idEntraineur = ?");
		
		$requete->bindValue(1,$uneInfoTitulaire);
		$requete->bindValue(2,$idEntraineur);
		
		echo "La modification est effectuée.";
		
		if(!$requete->execute())
		{
			die("Erreur dans modif Equipe : ".$requete->errorCode());
		}
		return $idEntraineur;
	}

	public function modifVacataire($idEntraineur,$uneInfoVacataire)
	{	$requete = $this->conn->prepare("UPDATE vacataire SET telephoneVacataire = ? where idEntraineur = ?");
		
		$requete->bindValue(1,$uneInfoVacataire);
		$requete->bindValue(2,$idEntraineur);
		
		echo "La modification est effectuée.";
		
		if(!$requete->execute())
		{
			die("Erreur dans modif Equipe : ".$requete->errorCode());
		}
		return $idEntraineur;
	}
	
	public function modifSpecialite($idSpecialite,$unLibSpecialite)
	{	$requete = $this->conn->prepare("UPDATE specialite SET libSpecialite = ? where idSpecialite = ?");
		
		$requete->bindValue(1,$unLibSpecialite);
		$requete->bindValue(2,$idSpecialite);
		
		echo "La modification est effectuée.";
		
		if(!$requete->execute())
		{
			die("Erreur dans modif Spécialité : ".$requete->errorCode());
		}
		return $idSpecialite;
	}

	/***********************************************************************************************
	C'est la fonction qui permet de charger les tables et de les mettre dans un tableau 2 dimensions. La petite fontions specialCase permet juste de psser des minuscules aux majuscules pour les noms des tables de la base de données
	************************************************************************************************/
	public function chargement($uneTable)
	{
		$lesInfos=null;
		$nbTuples=0;
		$stringQuery="SELECT * FROM ";
		$stringQuery = $this->specialCase($stringQuery,$uneTable);
		$query = $this->conn->prepare($stringQuery);
		if($query->execute())
		{
			while($row = $query->fetch(PDO::FETCH_NUM))
			{
				$lesInfos[$nbTuples] = $row;
				$nbTuples++;
			}
		}
		else
		{
			die('Problème dans chargement : '.$query->errorCode());
		}
		return $lesInfos;
	}

	private function specialCase($stringQuery,$uneTable)
	{
			$uneTable = strtoupper($uneTable);
			switch ($uneTable) {
			case 'VACATAIRE':
				$stringQuery.='vacataire';
				break;
			case 'EQUIPE':
				$stringQuery.='equipe';
				break;
			case 'ADHERENT':
				$stringQuery.='adherent';
				break;
			case 'ENTRAINEUR':
				$stringQuery.='entraineur';
				break;
			case 'TITULAIRE':
				$stringQuery.='titulaire';
				break;
			case 'SPECIALITE':
				$stringQuery.='specialite';
				break;
			case 'ADHERENTEQUIPE':
				$stringQuery.='adherentequipe';
				break;
			case 'ENTRAINEURSPECIALITE':
				$stringQuery.='entraineurspecialite';
				break;
			default:
				die('Pas une table valide');
				break;
			}

			return $stringQuery.";";
	}
	
	/**************************************************************************
	fonction qui permet d'avoir le prochain identifiant de la table. Elle est là uniquement parce que nous n'avons pas d'autoincremente dans notre base de données
	***************************************************************************/
	public function donneProchainIdentifiant($uneTable)
	{
		$stringQuery = $this->specialCase("SELECT * FROM ",$uneTable);
		$requete = $this->conn->prepare($stringQuery);
		//$requete->bindValue(1,$unIdentifiant);

		if($requete->execute())
		{
			$nb=0;
			while($row = $requete->fetch(PDO::FETCH_NUM))
			{
				$nb = $row[0];
			}
			return $nb+1;
		}
		else
		{
			die('Erreur sur donneProchainIdentifiant : '+$requete->errorCode());
		}
	}
	
	/************************************************************************
     Fonction qui me permettent d'obtenir le numéro max pour l'entraineur car comme nous avons un héritage, nous ne pouvons pas savoir le dernier numéro grace à conteneurVacataire ou conteneurTitulaire et normalement on a supprimé le conteneuEntraineur.
	 On aurait pu optimisé en ayant qu'une méthode et en faisant passer le nom de la table...
    *************************************************************************/	 
	public function donneNumeroMaxEntraineur()
	{
		$stringQuery = "SELECT idEntraineur FROM entraineur";
		$requete = $this->conn->prepare($stringQuery);

		if($requete->execute())
		{
			$nb=0;
			while($row = $requete->fetch(PDO::FETCH_NUM))
			{
				$nb + 1;
			}
			return $nb+1;
		}
		else
		{
			die('Erreur sur l identifiant de l entraineur : '+$requete->errorCode());
		}
	}
	
	public function donneNumeroMaxEquipe()
	{
		$stringQuery = "SELECT * FROM equipe";
		$requete = $this->conn->prepare($stringQuery);
		if($requete->execute())
		{
			$nb=0;
			while($row = $requete->fetch(PDO::FETCH_NUM))
			{
				$nb + 1;
			}
			return $nb+1;
		}
		else
		{
			die('Erreur sur l identifiant de l equipe : '+$requete->errorCode());
		}
	}
	
	public function donneNumeroMaxAdherent()
	{
		$stringQuery = "SELECT * FROM adherent";
		$requete = $this->conn->prepare($stringQuery);
		if($requete->execute())
		{
			$nb=0;
			while($row = $requete->fetch(PDO::FETCH_NUM))
			{
			$nb + 1;
			}
			return $nb+1;
		}
		else
		{
			die('Erreur sur l identifiant de l adherent : '+$requete->errorCode());
		}
	}
		
}