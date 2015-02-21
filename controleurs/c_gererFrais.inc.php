<?php

/**
 * Fichier qui s'occupe de toute la gestion des frais 
 * @author chrysinus@gmail.com
 * 
 */
require("vues/v_sommaireVisiteur.inc.php");
$idVisiteur = $_SESSION['idVisiteur'];
$mois = DateGsb::getMois(date("d/m/Y"));
$numAnnee = substr($mois, 0, 4);
$numMois = substr($mois, 4, 2);
$action = Session::implementer('action');
switch ($action) {
    case 'saisirFrais': {
            if ($pdo->estPremierFraisMois($idVisiteur, $mois)) {
                $pdo->creeNouvellesLignesFrais($idVisiteur, $mois);
            }
            break;
        }
    case 'validerMajFraisForfait': {
            $lesFrais = $_REQUEST['txt_lesFrais'];
            if (FiltreCtrl::estTableauEntiers($lesFrais)) {
                $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
            } else {
                Err::ajouterErreur("Les valeurs des frais doivent être numériques");
                require("vues/v_erreurs.inc.php");
            }
            break;
        }
    case 'validerCreationFrais': {
            $dateFrais = Session::implementer('dateFrais');
            $libelle = Session::implementer('libelle');
            $montant = Session::implementer('montant');
            FiltreCtrl::valideInfoFrais($dateFrais, $libelle, $montant);
            if (nbErreurs() != 0) {
                require("vues/v_erreurs.inc.php");
            } else {
                $pdo->creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,
                                                  $dateFrais, $montant);
            }
            break;
        }
    case 'supprimerFrais': {
            $idFrais = $_REQUEST['idFrais'];
            $pdo->supprimerFraisHorsForfait($idFrais);
            break;
        }
}
$lesFraisHorsForfait = $pdo->obtenirLesFraisHorsForfait($idVisiteur, $mois);
$lesFraisForfait = $pdo->obtenirLesFraisForfait($idVisiteur, $mois);
require("vues/v_listeFraisForfait.inc.php");
require("vues/v_listeFraisHorsForfait.inc.php");
?>