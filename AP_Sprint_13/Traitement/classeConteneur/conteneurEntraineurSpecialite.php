<?php

Class conteneurEntraineurSpecialite
	{
	//attribut de type arrayObjet, mais on est en php donc on ne met pas les types
	private $lesEntraineursSpecialites;
	
	//le constructeur créer un tableau vide
	public function __construct()
		{
		$this->lesEntraineursSpecialites = new arrayObject();
		}

        //les méthodes habituellement indispensables
	public function ajouterUnEntraineurSpecialite($unIdEntraineur, $unIdSpecialite)
    {	$unEntraineurSpecialite = new metierEntraineurSpecialite($unIdEntraineur, $unIdSpecialite);
    $this->lesEntraineursSpecialites->append($unEntraineurSpecialite);
        
    }

    public function listeDesEntraineursSpecialites()
		{
		$liste = '';
		foreach ($this->lesEntraineursSpecialites as $unEntraineurSpecialite)
			{	$liste = $liste.$unEntraineurSpecialite->afficheEntraineurSpecialite();
			}
		return $liste;
		}
		public function getLesEntraineursSpecialites()
		{
			return $this->lesEntraineursSpecialites;
		}
    }