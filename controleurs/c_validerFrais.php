<?php

include("vues/v_sommaireC.php");
$action = implementer('action');
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
            $mois = implementer('mois');
            $idVisiteur = implementer('visiteur');
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
            $lesFrais = implementer('fraisForfait');
            $etat = implementer('etatFraisHorsForfait');
            var_dump($etat);
            $mois = implementer('mois');
            $idVisiteur = implementer('visiteur');
            //mise a jour de ligneFraisForfait
            $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
            //traitement frais hors forfaits
            
            foreach($etat as $id){
                switch($id){
                    case 'supprime':{
                        //supprimer la ligne de frais hors forfait
                        break;
                    }  
                    case 'reporte':{
                        //reporter la ligne de frais hors forfait le mois suivant
                        break;
                    } 
                }
            }
        }
} 