<?php

Class metierAdherentEquipe
	{
	//ATTRIBUTS PRIVES-------------------------------------------------------------------------
	private $idAdherent;
	private $idEquipe;

    public function __construct($unIdAdherent, $unIdEquipe)
    {
    $this->idAdherent = $unIdAdherent;
    $this->idEquipe = $unIdEquipe;
    
    }

    //ACCESSEURS-------------------------------------------------------------------------------
	public function getIdAdherent()
    {
    return $this->idAdherent;
    }
    public function getIdEquipe()
    {
    return $this->idEquipe;
    }

    // méthode permettant d'afficher tous les attributs d'un seul coup
	public function afficheAdherentEquipe()
	{
		$liste=$this->getIdAdherent().' | '.$this->getIdEquipe().' | ';
		return $liste;
	}

    }
