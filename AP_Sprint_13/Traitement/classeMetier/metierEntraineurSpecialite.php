<?php

Class metierEntraineurSpecialite
	{
	//ATTRIBUTS PRIVES-------------------------------------------------------------------------
	private $idEntraineur;
	private $idSpecialite;
	
	
	
	//CONSTRUCTEUR-----------------------------------------------------------------------------
	public function __construct($unIdEntraineur, $unIdSpecialite)
		{
		$this->idEntraineur = $unIdEntraineur;
		$this->idSpecialite = $unIdSpecialite;
		
		}

     //ACCESSEURS-------------------------------------------------------------------------------
	public function getIdEntraineur()
    {
    return $this->idEntraineur;
    }
    public function getIdSpecialite()
    {
    return $this->idSpecialite;
    }

    // méthode permettant d'afficher tous les attributs d'un seul coup
	public function afficheEntraineurSpecialite()
	{
		$liste=$this->getIdEntraineur().' | '.$this->getIdSpecialite().' | ';
		return $liste;
	}
    
    }