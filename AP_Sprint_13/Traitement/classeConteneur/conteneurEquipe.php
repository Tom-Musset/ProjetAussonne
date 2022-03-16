<?php


class conteneurEquipe
	{
	//attribut de type arrayObjet, mais on est en php donc on ne met pas les types
	private $lesEquipes;
	
	//le constructeur créer un tableau vide
	public function __construct()
		{
		$this->lesEquipes = new arrayObject();
		}
	
	//les méthodes habituellement indispensables
	public function ajouterUneEquipe($unIdEquipe, $unNomEquipe, $unNbrPlaceEquipe, $unAgeMinEquipe, $unAgeMaxEquipe, $unSexeEquipe, $unEntraineur, $uneSpecialite)
	{
		$uneEquipe = new metierEquipe($unIdEquipe, $unNomEquipe, $unNbrPlaceEquipe, $unAgeMinEquipe, $unAgeMaxEquipe, $unSexeEquipe,$unEntraineur, $uneSpecialite);
		$this->lesEquipes->append($uneEquipe);
			
	}
	
	public function modifierUneEquipe($unIdEquipe, $unNomEquipe, $unNbrPlaceEquipe, $unAgeMinEquipe, $unAgeMaxEquipe, $unSexeEquipe, $unEntraineur,  $uneSpecialite)
	{
			
		foreach ($this->lesEquipes as $uneEquipe)
		{
			if ($uneEquipe->getIdEquipe() == $unIdEquipe)
			{
				$uneEquipe->setNomEquipe = $unNomEquipe;
				$uneEquipe->setNbrPlaceEquipe = $unNbrPlaceEquipe;
				$uneEquipe->setAgeMinEquipe = $unAgeMinEquipe;
				$uneEquipe->setAgeMaxEquipe = $unAgeMaxEquipe;
				$uneEquipe->setSexeEquipe = $unSexeEquipe;
				$uneEquipe->setLEntraineur = $unEntraineur;
				$uneEquipe->setLaSpecialite = $uneSpecialite;
			}
		}
	}

	
	
	public function nbEquipe()
		{
		return $this->lesEquipes->count();
		}	
		
	public function listeDesEquipes()
		{
		$liste = '';
		foreach ($this->lesEquipes as $uneEquipe)
			{	$liste = $liste.$uneEquipe->afficheEquipe();
			}
		return $liste;
		}
	public function getLesEquipes(){
		return $this->lesEquipes;
	}
	public function listeDesEquipesNomId()
	{
		$array = array();

	foreach ($this->lesEquipes as $uneEquipe)
		{	
			$array[$uneEquipe->getIdEquipe()] = $uneEquipe->getNomEquipe();
			
		}
	return $array;
	}
		
	public function lesEquipesAuFormatHTML()
		{
		$liste = "<SELECT name = 'idEquipe'>";
		foreach ($this->lesEquipes as $uneEquipe)
			{
			$liste = $liste."<OPTION value='".$uneEquipe->getIdEquipe()."'>".$uneEquipe->getNomEquipe()."</OPTION>";
			}
		$liste = $liste."</SELECT>";
		return $liste;
		}
	
	public function EquipeEntraineur($idEntraineur){
		$a=0;
		$array=array();
		foreach ($this->lesEquipes as $uneEquipe)
		{	
			if($uneEquipe->getLEntraineur()->getIdEntraineur() == $idEntraineur){
				$array[$a]=$uneEquipe->getIdEquipe();
				$a+=1;
			}
			
		}
		return $array;
	}
	
	public function donneObjetEquipeDepuisNumero($unIdEquipe)
		{
		
		$trouve=false;
		$laBonneEquipe=null;
		$iEquipe = $this->lesEquipes->getIterator();
		while ((!$trouve)&&($iEquipe->valid()))
			{
				if ($iEquipe->current()->getIdEquipe()==$unIdEquipe)
				{
				$trouve=true;
				$laBonneEquipe = $iEquipe->current();
				}
			else
				$iEquipe->next();
			}
		return $laBonneEquipe;
		}	
	}
?> 