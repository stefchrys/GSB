
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
require_once ("include/class.fpdf.inc.php");
require_once("include/class.Connect.inc.php");
require_once("include/class.TypeNum.inc.php");
require_once("include/class.DateGsb.inc.php");
require_once("include/class.Err.inc.php");
require("vues/v_entete.inc.php");
session_start();
$pdo = PdoGsb::getPdoGsb();
$estConnecte = Connect::estConnecte();


/* Verifier le cas d'utilisation en cours (uc) et par défaut l'initialise
  à l'état "connexion" */

if (!isset($_REQUEST['uc']) || $estConnecte == 0) {
    $_REQUEST['uc'] = 'connexion';
}
$uc = $_REQUEST['uc'];

switch ($uc) {
    case 'connexion': {
            require("controleurs/c_connexion.inc.php");
            break;
        }
    case 'gererFrais' : {
            require("controleurs/c_gererFrais.inc.php");
            break;
        }
    case 'etatFrais' : {
            require("controleurs/c_etatFrais.inc.php");
            break;
        }
    case 'validerFrais': {
            require("controleurs/c_validerFrais.inc.php");
            break;
        }
    case 'suivrePaiement': {
            require("controleurs/c_suivrePaiement.inc.php");
            break;
        }
}
require("vues/v_pied.inc.php");
