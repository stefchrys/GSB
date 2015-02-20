<?php
/**
 * Fichier qui gère l'affichage des frais
 * 
 * @author chrysinus@gmail.com
 * 
 */
require("vues/v_sommaireVisiteur.inc.php");
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];
switch ($action) {
    case 'selectionnerMois': {
            $lesMois = $pdo->obtenirLesMoisDisponibles($idVisiteur, "year");
            // Afin de sélectionner par défaut le dernier mois dans la zone de liste
            // on demande toutes les clés, et on prend la première,
            // les mois étant triés de manière décroissante 
            $lesCles = array_keys($lesMois);
            $moisASelectionner = $lesCles[0];
            require("vues/v_listeMois.inc.php");
            break;
        }
    case 'voirEtatFrais': {
            $leMois = $_REQUEST['lstMois'];
            $lesMois = $pdo->obtenirLesMoisDisponibles($idVisiteur, "year");
            $moisASelectionner = $leMois;
            require("vues/v_listeMois.inc.php");
            $lesFraisHorsForfait = $pdo->obtenirLesFraisHorsForfait($idVisiteur, $leMois);
            $lesFraisForfait = $pdo->obtenirLesFraisForfait($idVisiteur, $leMois);
            $lesInfosFicheFrais = $pdo->obtenirLesInfosFicheFrais($idVisiteur, $leMois);
            $numAnnee = substr($leMois, 0, 4);
            $numMois = substr($leMois, 4, 2);
            $libEtat = $lesInfosFicheFrais['libEtat'];
            $montantValide = $lesInfosFicheFrais['montantValide'];
            $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
            $dateModif = $lesInfosFicheFrais['dateModif'];
            $dateModif = DateGsb::dateAnglaisVersFrancais($dateModif);
            require("vues/v_etatFrais.inc.php");
            break;
        }
        }
?>