<?php
	

Class metierTitulaire extends metierEntraineur
	{
	//ATTRIBUTS PRIVES-------------------------------------------------------------------------
	private $dateEmbauche; 
	
		
	//CONSTRUCTEUR-----------------------------------------------------------------------------
	public function __construct($unIdEntraineur, $unNomEntraineur, $unLoginEntraineur, $unPwdEntraineur,$uneDateEmbauche)
		{
		parent::__construct($unIdEntraineur,$unNomEntraineur, $unLoginEntraineur, $unPwdEntraineur);
		$this->dateEmbauche = $uneDateEmbauche;
		}
	
	//ACCESSEURS-------------------------------------------------------------------------------
	public function getDateEmbauche()
	{
		return $this->dateEmbauche;
	}
	public function getNomTitulaire()
	{
		return parent::getNomEntraineur();
	}
	public function getIdTitulaire()
	{
		return parent::getIdEntraineur();
	}

	public function getLogin()
	{
		return parent::getLoginEntraineur();
	}

	
	
		
	//SETTEUR------------------------------------------------------------
	
	public function setDateEmbauche($uneDateEmbauche)
		{
		$this->dateEmbauche = $uneDateEmbauche;
		}
				
	// méthode permettant d'afficher tous les attributs d'un seul coup
	public function afficheTitulaire()
	{
		$liste=parent::afficheEntraineur();
		$liste=$liste.$this->getDateEmbauche().'|';
		return $liste;
	}			    
	
	}
	
?>