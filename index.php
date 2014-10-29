<?php
require_once("include/fct.inc.php");
require_once ("include/class.pdogsb.inc.php");
include("vues/v_entete.php") ;
session_start();
$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte();
//si pas de variable d'environnements initialisés,
//cela signifie qu'on  est sur la page d'accuel en attente de connexion
if(!isset($_REQUEST['uc']) || $estConnecte==0){
     $_REQUEST['uc'] = 'connexion';
}	 
$uc = $_REQUEST['uc'];
//on check à quel cas d'utilisation correspond $uc et on include le bon CTRLR
switch($uc){
	case 'connexion':{
		include("controleurs/c_connexion.php");break;
	}
	case 'gererFrais' :{
		include("controleurs/c_gererFrais.php");break;
	}
	case 'etatFrais' :{
		include("controleurs/c_etatFrais.php");break; 
	}
}
include("vues/v_pied.php") ;
?>

