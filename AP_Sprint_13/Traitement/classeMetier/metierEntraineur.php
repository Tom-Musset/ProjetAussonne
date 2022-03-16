<?php
Class metierEntraineur
	{
	//ATTRIBUTS PRIVES-------------------------------------------------------------------------
	private $idEntraineur; 
	private $nomEntraineur;
	private $loginEntraineur;
	private $pwdEntraineur;
		
	//CONSTRUCTEUR-----------------------------------------------------------------------------
	public function __construct($unIdEntraineur, $unNomEntraineur,$unLoginEntraineur,$unPwdEntraineur)
		{
		$this->idEntraineur = $unIdEntraineur;
		$this->nomEntraineur = $unNomEntraineur;
		$this->loginEntraineur = $unLoginEntraineur;
		$this->pwdEntraineur = $unPwdEntraineur;
		}
	
	//ACCESSEURS-------------------------------------------------------------------------------
	public function getIdEntraineur()
	{
		return $this->idEntraineur;
	}
	public function getNomEntraineur()
		{
		return $this->nomEntraineur;
		}
	public function getLoginEntraineur()
		{
		return $this->loginEntraineur;
		}
	public function getPwdEntraineur()
		{
		return $this->pwdEntraineur;
		}
	
	//SETTEUR------------------------------------------------------------
	
	public function setIdEntraineur($unIdEntraineur)
		{
		$this->idEntraineur = $unIdEntraineur;
		}
	public function setNomEntraineur($unNomEntraineur)
		{
		$this->nomEntraineur = $unNomEntraineur;
		}
	public function setLoginEntraineur($unLoginEntraineur)
		{
		$this->loginEntraineur = $unLoginEntraineur;
		}
	public function setPwdEntraineur($unPwdEntraineur)
		{
		$this->pwdEntraineur = $unPwdEntraineur;
		}
			
	// méthode permettant d'afficher tous les attributs d'un seul coup
	public function afficheEntraineur()
		{
		return $this->getIdEntraineur().' | '.$this->getNomEntraineur().' | '.$this->getLoginEntraineur().' |';
		}			    
	
	}
	
?>