<?php

Class conteneurAdherentEquipe
	{
	//attribut de type arrayObjet, mais on est en php donc on ne met pas les types
	private $lesAdherentsEquipes;
	
	//le constructeur créer un tableau vide
	public function __construct()
		{
		$this->lesAdherentsEquipes = new arrayObject();
		}

        //les méthodes habituellement indispensables
	public function ajouterUnAdherentEquipe($unIdAdherent, $unIdEquipe)
    {	$unAdherentEquipe = new metierAdherentEquipe($unIdAdherent, $unIdEquipe);
    $this->lesAdherentsEquipes->append($unAdherentEquipe);
        
    }
    public function listeDesAdherentsEquipes()
		{
		$liste = '';
		foreach ($this->lesAdherentsEquipes as $unAdherentEquipe)
			{	$liste = $liste.$unAdherentEquipe->afficheAdherentEquipe();
			}
		return $liste;
		}
    
    
    
    }