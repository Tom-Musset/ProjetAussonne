<?php


class conteneurSpecialite
	{

	private $lesSpecialites;

    public function __construct()
		{
		$this->lesSpecialites = new arrayObject();
		}

	public function getLesSpecialites(){
		return $this->lesSpecialites;
	}
	public function ajouterUneSpecialite($unId‪Specialite, $unLibSpecialite)
	{
		$uneSpecialite = new metierSpecialite($unId‪Specialite, $unLibSpecialite);
		$this->lesSpecialites->append($uneSpecialite);
			
	}

    public function modifierUneSpecialite($unId‪Specialite, $unLibSpecialite)
	{
			
		foreach ($this->lesSpecialites as $uneSpecialite)
		{
			if ($uneSpecialite->getIdSpecialite() == $unId‪Specialite)
			{
				$uneSpecialite->setId‪Specialite = $unId‪Specialite;
				$uneSpecialite->setLibSpecialite = $unLibSpecialite;
			}
		}
	}

	public function listeDesSpecialitesArray()
		{
		$liste = array();
		$a=1;
		foreach ($this->lesSpecialites as $uneSpecialite)
			{	$liste[$a]=array($uneSpecialite->getIdSpecialite(),$uneSpecialite->getLibSpecialite());
				$a+=1;
			}
		return $liste;
		}

	
	
	public function nbSpecialite()
		{
		return $this->lesSpecialites->count();
		}	
		
	public function listeDesSpecialites()
		{
		$liste = '';
		foreach ($this->lesSpecialites as $uneSpecialite)
			{	$liste = $liste.$uneSpecialite->getLibSpecialite().' | ';
			}
		return $liste;
		}

	public function listeDesSpecialitesLibId()
		{
			$array = array();
	
		foreach ($this->lesSpecialites as $laSpecialite)
			{	
				$array[$laSpecialite->getIdSpecialite()] = $laSpecialite->getLibSpecialite();
				
			}
		return $array;
		}
	public function donneObjetSpecialiteDepuisNumero($unIdSpecialite)
		{
		$trouve=false;
		$laBonneSpecialite=null;
		$iSpecialite = $this->lesSpecialites->getIterator();
		while ((!$trouve)&&($iSpecialite->valid()))
			{
			if ($iSpecialite->current()->getIdSpecialite()==$unIdSpecialite)
				{
				$trouve=true;
				$laBonneSpecialite = $iSpecialite->current();
				}
			else
				$iSpecialite->next();
			}
		return $laBonneSpecialite;
		}	
	public function lesSpecialitesAuFormatHTML()
		{
		$liste = "<SELECT name = 'idSpecialite'>";
		foreach ($this->lesSpecialites as $laSpecialite)
			{
			$liste = $liste."<OPTION value='".$laSpecialite->getIdSpecialite()."'>".$laSpecialite->getLibSpecialite()."</OPTION>";
			}
		$liste = $liste."</SELECT>";
		return $liste;
		}
	
}

?>