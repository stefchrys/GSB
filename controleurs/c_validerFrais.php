<?php

include("vues/v_sommaireC.php");
if (isset($_REQUEST['action']) && is_string($_REQUEST['action'])) {
    $action = $_REQUEST['action'];
}
if (isset($_REQUEST['mois']) && is_string($_REQUEST['mois'])) {
    $mois = $_REQUEST['mois'];
}
if (isset($_REQUEST['visiteur']) && is_string($_REQUEST['visiteur'])) {
    $idVisiteur = $_REQUEST['visiteur'];
}
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

            $visiteurASelectionner = $idVisiteur;
            $dateASelectionner = $mois;
            $ficheAnnee = substr($mois, 0, 4);
            $ficheMois = substr($mois, 4, 2);
            $etat = "CL";
            //chercher la fiche
            $laFiche = $pdo->ficheExiste($idVisiteur, $mois, $etat);
            //si fiche existe on affiche la fiche frais correspondante
            if ($laFiche) {
                $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
                $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
                $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $mois);
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
    case 'validerTraitement': {
            //mettre a jour table fraisforfait
            $idFrais = $pdo->getLesIdFrais();
            $lesFrais = remplirTableauFrais($idFrais);
            $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
        }
}