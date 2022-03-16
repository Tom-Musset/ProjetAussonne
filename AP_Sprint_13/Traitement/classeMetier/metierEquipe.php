<?php
Class metierEquipe
	{
	//ATTRIBUTS PRIVES-------------------------------------------------------------------------
	private $id‪Equipe; 
	private $nomEquipe; 
	private $nbrPlaceEquipe; 
	private $ageMinEquipe; 
	private $ageMaxEquipe; 
	private $sexeEquipe; 
	private $lEntraineur;
	private $specialite;
	
	
	//CONSTRUCTEUR-----------------------------------------------------------------------------
	
	public function __construct($unId‪Equipe, $unNomEquipe, $unNbrPlaceEquipe, $unAgeMinEquipe, $unAgeMaxEquipe, $unSexeEquipe, $unEntraineur,  $uneSpecialite)
		{
		$this->id‪Equipe = $unId‪Equipe;
		$this->nomEquipe = $unNomEquipe;
		$this->nbrPlaceEquipe = $unNbrPlaceEquipe;
		$this->ageMinEquipe = $unAgeMinEquipe;
		$this->ageMaxEquipe = $unAgeMaxEquipe;
		$this->sexeEquipe = $unSexeEquipe;
		$this->lEntraineur = $unEntraineur;
		$this->specialite =  $uneSpecialite;
		}
	
	//ACCESSEURS-------------------------------------------------------------------------------
	public function getIdEquipe()
	{
		return $this->id‪Equipe;
	}
		
		
	public function getNomEquipe()
		{
		return $this->nomEquipe;
		}
	public function getNbrPlaceEquipe()
		{
		return $this->nbrPlaceEquipe;
		}
	public function getAgeMinEquipe()
		{
		return $this->ageMinEquipe;
		}
	public function getAgeMaxEquipe()
		{
		return $this->ageMaxEquipe;
		}
	public function getSexeEquipe()
		{
		return $this->sexeEquipe;
		}
	public function getlEntraineur()
	{
		return $this->lEntraineur;
	}
	public function getSpecialite()
	{
		return $this->specialite;
	}
	
	//SETTEUR------------------------------------------------------------
	
	public function setId‪Equipe($unId‪Equipe)
		{
		$this->id‪Equipe = $unId‪Equipe;
		}
	public function setNomEquipe($unNomEquipe)
		{
		$this->nomEquipe = $unNomEquipe;
		}
	public function setNbrPlaceEquipe($unNbrPlaceEquipe)
		{
		$this->nbrPlaceEquipe = $unNbrPlaceEquipe;
		}
	public function setAgeMaxEquipe($unAgeMaxEquipe)
		{
		$this->ageMaxEquipe = $unAgeMaxEquipe;
		}
	public function setAgeMinEquipe($unAgeMinEquipe)
		{
		$this->ageMinEquipe = $unAgeMinEquipe;
		}
	public function setSexeEquipe($unSexeEquipe)
		{
		$this->sexeEquipe = $unSexeEquipe;
		}
	public function setLEntraineur($unEntraineur)
	{
		echo $this->lEntraineur->getNomEntraineur();
		$this->lEntraineur = $unEntraineur;
	}
	public function setSpecialite($uneSpecialite)
		{
		$this->specialite = $uneSpecialite;
		}
		
	// méthode permettant d'afficher tous les attributs d'un seul coup
	public function afficheEquipe()
	{
		return $liste=$this->getNomEquipe().' | '.$this->getNbrPlaceEquipe().' | '.$this->getAgeMinEquipe().'|'.$this->getAgeMaxEquipe().' |'.$this->getSexeEquipe().'|'.$this->getLEntraineur()->getNomEntraineur().'|'.$this->getSpecialite()->getLibSpecialite().'|';
					
	}			    
	
	}
	
?>