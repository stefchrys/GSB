<?php
/**
 * Controleur principal
 
 * Ce controleur sert de point d'entrée à l'application et sera appelé à chaque
 * soumission d'un formulaire.
 * @author chrysinus@gmail.com
 * @package default
 * @date 29/10/2014
 */

require_once("include/fct.inc.php");
require_once ("include/class.pdogsb.inc.php");
include("vues/v_entete.php") ;
session_start();
$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte();

/* Verifier le cas d'utilisation en cours (uc) et par défaut l'initialise
à l'état "connexion" */

if(!isset($_REQUEST['uc']) || $estConnecte == 0){
     $_REQUEST['uc'] = 'connexion';
}	 
$uc = $_REQUEST['uc'];

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