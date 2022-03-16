<?php

Class conteneurAdherent
	{
	//attribut de type arrayObjet, mais on est en php donc on ne met pas les types
	private $lesAdherents;
	
	//le constructeur créer un tableau vide
	public function __construct()
		{
		$this->lesAdherents = new arrayObject();
		}
	public function getLesAdherents(){
		return $this->lesAdherents;
	}
	//les méthodes habituellement indispensables
	public function ajouterUnAdherent($unIdAdherent, $unNomAdherent, $unPrenomAdherent, $ageAdherent, $sexeAdherent,$unLoginAdherent, $unPwdAdherent)
		{	$unAdherent = new metierAdherent($unIdAdherent, $unNomAdherent, $unPrenomAdherent, $ageAdherent, $sexeAdherent,$unLoginAdherent, $unPwdAdherent);
		$this->lesAdherents->append($unAdherent);
			
		}
	public function nbAdherent()
		{
		return $this->lesAdherents->count();
		}	
		
	public function listeDesAdherents()
		{
		$liste = '';
		foreach ($this->lesAdherents as $unAdherent)
			{	$liste = $liste.$unAdherent->afficheAdherent();
			}
		return $liste;
		}

	public function modifierUnAdherent($unIdAdherent, $unNomAdherent, $unPrenomAdherent, $unAgeAdherent, $unSexeAdherent, $unLoginAdherent, $unPwdAdherent)
	{
			
		foreach ($this->lesAdherents as $unAdherent)
		{
			if ($unAdherent->getIdAdherent() == $unIdAdherent)
			{
				$unAdherent->setNomAdherent = $unNomAdherent;
				$unAdherent->setPrenomAdherent = $unPrenomAdherent;
				$unAdherent->setAgeAdherent = $unAgeAdherent;
				$unAdherent->setSexeAdherent = $unSexeAdherent;
				$unAdherent->setLoginAdherent = $unLoginAdherent;
				$unAdherent->setPwdAdherent = $unPwdAdherent;
			}
		}
	}
	
	public function donneAdherentEquipe($idEquipe){
		$liste = '';
			foreach ($this->lesAdherents as $unAdherent)
			{
				if ($unAdherent->getlIdEquipeDelAdherent() == $idEquipe)
				{	
					$liste = $liste.$unAdherent->afficheCoequipier();
				}
			}
			return $liste;
	}

	public function AdherentEntraineur($idEquipesDeLentraineur){
		$liste = '';
		for ($i=0; $i<sizeof($idEquipesDeLentraineur); $i++) {
			foreach ($this->lesAdherents as $unAdherent)
			{
				if ($unAdherent->getlIdEquipeDelAdherent() == $idEquipesDeLentraineur[$i])
				{
					$liste = $liste.$unAdherent->afficheAdherentPourEntraineur();
				}
			}
		}
		return $liste;
	}
		
	public function lesAdherentsAuFormatHTML()
		{
		$liste = "<SELECT name = 'idAdherent'>";
		foreach ($this->lesAdherents as $unAdherent)
			{
			$liste = $liste."<OPTION value='".$unAdherent->getIdAdherent()."'>".$unAdherent->getNomAdherent()."</OPTION>";
			}
		$liste = $liste."</SELECT>";
		return $liste;
		}		

	public function donneObjetAdherentDepuisNumero($unIdAdherent)
		{
		$trouve=false;
		$leBonAdherent=null;
		$iAdherent = $this->lesAdherents->getIterator();
		while ((!$trouve)&&($iAdherent->valid()))
			{
			if ($iAdherent->current()->getIdAdherent()==$unIdAdherent)
				{
				$trouve=true;
				$leBonAdherent = $iAdherent->current();
				}
			else
				$iAdherent->next();
			}
		return $leBonAdherent;
		}		
	}
?> 