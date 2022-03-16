<?php
	include ('Outil/autoload.php');
	$role=0;
	if (!isset($monControleur))
	{
		$monControleur = new controleur();
		$monControleur->afficheEntete();
	}

	if(!isset($_COOKIE['c']))
	{
		$timestamp_marque= time()+60;
		$cookie_vie=time()+60*60*24;
		setcookie("c",$timestamp_marque,$cookie_vie);
	}
	
	if ((isset($_GET['vue']))&& (isset($_GET['action'])))
	{
		$monControleur->affichePage($_GET['action'],$_GET['vue'],$role);
	}
	else
	{
		require "vues/ihm/menu.php";
		
	
	}
	
	//if (!isset($monControleur))
	//{
		$monControleur->affichePiedPage();
	//}
?>