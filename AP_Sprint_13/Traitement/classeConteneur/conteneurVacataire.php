<?php


class conteneurVacataire
	{
	//attribut de type arrayObjet, mais on est en php donc on ne met pas les types
	private $lesVacataires;
	
	//le constructeur créer un tableau vide
	public function __construct()
		{
		$this->lesVacataires = new arrayObject();
		}
	
	//les méthodes habituellement indispensables
	public function ajouterUnVacataire($unIdEntraineur, $unNomEntraineur,$unLoginEntraineur, $unPwdEntraineur,$unTelephone)
	{
		$unVacataire = new metierVacataire($unIdEntraineur, $unNomEntraineur,$unLoginEntraineur, $unPwdEntraineur, $unTelephone);
		$this->lesVacataires->append($unVacataire);
			
	}

	public function modifierUnVacataire($idEntraineur, $nomEntraineur, $loginEntraineur, $pwdEntraineur, $infoEntraineur)
	{
			
		foreach ($this->lesVacataires as $unVacataire)
		{
			if ($unVacataire->getIdEntraineur() == $idEntraineur)
			{
				$unVacataire->setNomEntraineur = $nomEntraineur;
				$unVacataire->setLoginEntraineur = $loginEntraineur;
				$unVacataire->setPwdEntraineur = $pwdEntraineur;
				$unVacataire->setTelephone = $infoEntraineur;
			}
		}
	}
	
	public function nbVacataire()
		{
		return $this->lesVacataires->count();
		}	
	
	public function getLesVacataires()
	{
		return $this->lesVacataires;
	}	
	public function listeDesVacataires()
		{
		$liste = '';
		foreach ($this->lesVacataires as $unVacataire)
			{	$liste = $liste.$unVacataire->afficheVacataire();
			}
		return $liste;
		}

	public function listeDesVacatairesNomId()
	{
		$array = array();

	foreach ($this->lesVacataires as $unVacataire)
		{	
			$array[$unVacataire->getIdEntraineur()] = $unVacataire->getNomEntraineur();
			
		}
	return $array;
	}
		
	public function lesVacatairesAuFormatHTML()
		{
		$liste = "<SELECT name = 'idVacataire'>";
		foreach ($this->lesVacataires as $unVacataire)
			{
			$liste = $liste."<OPTION value='".$unVacataire->getIdEntraineur()."'>".$unVacataire->getNomEntraineur()."</OPTION>";
			}
		$liste = $liste."</SELECT>";
		return $liste;
		}		
	
	public function donneObjetVacataireDepuisNumero($unIdVacataire)
		{
		$trouve=false;
		$leBonVacataire=null;
		$iVacataire = $this->lesVacataires->getIterator();
		while ((!$trouve)&&($iVacataire->valid()))
			{
			if ($iVacataire->current()->getIdEntraineur()==$unIdVacataire)
				{
				$trouve=true;
				$leBonVacataire = $iVacataire->current();
				}
			else
				$iVacataire->next();
			}
		return $leBonVacataire;
		}	
		
		public function chercherExistanceIdVacataire($unId)
		{
		$trouve=false;
		$iVacataire = $this->lesVacataires->getIterator();
		while ((!$trouve)&&($iVacataire->valid()))
			{	
				if ($iVacataire->current()->getIdEntraineur()==$unId)
					$trouve=true;
			$iVacataire->next();
			}
		return $trouve;
		}	
			
	}
?> 