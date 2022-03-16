<?php
session_start(['cookie_lifetime' => 43200,'cookie_secure' => true,'cookie_httponly' => true]);
include_once  'accesBD.php';
$maBD = new accesBD();
$typeNouvelleChoisi=$_POST["typeNews"];
$data = array();
$data["retour"] = $maBD->listeDesNouvellesPourUnType($typeNouvelleChoisi);
echo json_encode($data);







?>