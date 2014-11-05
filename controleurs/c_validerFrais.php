<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include("vues/v_sommaireC.php");
$action = $_REQUEST['action'];
$visiteurs = $pdo->getListeVisiteurs();
$tableauDate = $pdo->getDouzeMois();

switch ($action) {
    case 'choixVisiteurMois': {
            /* Afin de sélectionner par défaut le dernier visiteur
              dans la zone de liste et le dernier mois,
              on demande toutes les clés, et on prend la première */
            $lesClesVisiteurs = array_keys($visiteurs);
            $visiteurASelectionner = $lesClesVisiteurs[0];
            $lesClesDate = array_keys($tableauDate);
            $dateASelectionner = $lesClesDate[0];
            include('vues/v_listeVisiteurMoisC.php');
            break;
        }

    case 'validerChoixVisiteurMois': {
            //controler qu'une fiche de frais existe
            $moisChoisi = $_REQUEST['mois'];
            $idVisiteur = $_REQUEST['visiteur'];
            $visiteurASelectionner = $idVisiteur;
            $dateASelectionner = $moisChoisi;
            $ficheAnnee = substr($moisChoisi, 0, 4);
            $ficheMois = substr($moisChoisi, 4, 2);
            
            //chercher la fiche
            $laFiche = $pdo->ficheExiste($idVisiteur, $moisChoisi);
             //si fiche existe on affiche la fiche frais correspondante
            if ($laFiche != null) {
                $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $moisChoisi);
                $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $moisChoisi);
                $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $moisChoisi);
                include('vues/v_listeVisiteurMoisC.php');
                include('vues/v_traiterFrais.php');
            } else {
                //si existe pas retour vers le choix d'une fiche
                ajouterErreur("pas de fiches trouvées ce mois ci pour ce visiteur");
                include('vues/v_erreurs.php');
                include('vues/v_listeVisiteurMoisC.php');
            }

            break;
        }
}