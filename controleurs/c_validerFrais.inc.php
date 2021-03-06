<?php

require ("vues/v_sommaireComptable.inc.php");
$action = Session::implementer('action');
$visiteurs = $pdo->obtenirListeVisiteurs();
$tableauDate = $pdo->getDouzeMois();

//campagne de validation (double emploi avec service web c#)
//mais peut être considéré comme une securité en cas de defaillance du service web
$pdo->validationCampagne(); 

switch ($action) {
    case 'choixVisiteurMois': {

            /* Afin de sélectionner par défaut le dernier visiteur
              dans la zone de liste et le dernier mois,
              on demande toutes les clés, et on prend la première */
            $lesClesVisiteurs = array_keys($visiteurs);
            $visiteurASelectionner = $lesClesVisiteurs[0];
            $lesClesDate = array_keys($tableauDate);
            $dateASelectionner = $lesClesDate[0];           
            require('vues/v_listeVisiteurMoisComptable.inc.php');
            break;
        }
    case 'validerChoixVisiteurMois': {

            $mois = Session::implementer('mois');
            $idVisiteur = Session::implementer('visiteur');
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
                $lesFraisHorsForfait = $pdo->obtenirLesFraisHorsForfait($idVisiteur, $mois);
                $lesFraisForfait = $pdo->obtenirLesFraisForfait($idVisiteur, $mois);
                require('vues/v_listeVisiteurMoisComptable.inc.php');
                require('vues/v_traiterFrais.inc.php');
            } else {
                //si existe pas retour vers le choix d'une fiche
                Err::ajouterErreur("pas de fiches trouvées ce mois ci pour ce visiteur");
                require('vues/v_erreurs.inc.php');
                require('vues/v_listeVisiteurMoisComptable.inc.php');
            }
            break;
        }
    case 'validerTraitement': {

            //////////////////////traitement frais forfait//////////////////////////
            //tableau de frais forfait idFrais=>quantité
            $lesFrais = Session::implementer('fraisForfait');
            $mois = Session::implementer('mois');
            $idVisiteur = Session::implementer('visiteur');
            //mise a jour de ligneFraisForfait
            if (FiltreCtrl::estTableauEntiers($lesFrais)) {
                $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
                $lesFraisForfait = $pdo->obtenirLesFraisForfait($idVisiteur, $mois);
                //calcul du montant  composé des frais forfait validés par le comptable
                $montantValide = $pdo->sommeFrais($lesFraisForfait);
                
                 //////////////////traitement des frais hors forfaits /////////////////
                $lesFraisHorsForfait = $pdo->obtenirLesFraisHorsForfait($idVisiteur, $mois);
                $etat = Session::implementer('etatFraisHorsForfait');
                //creation d'un tableau associatif specifique
                $tableauFraisHF = ManierTableaux::fusionner($lesFraisHorsForfait, $etat);
                foreach ($tableauFraisHF as $frais) {
                    $libelle = $frais['libelle'];
                    $date = $frais['date'];
                    $montant = (float) $frais['montant'];
                    $etat = $frais['etat'];
                    $id = $frais['id'];
                    //si le frais est supprimé par le comptable
                    if ($etat == 'supprime') {
                        //on refuse le paiement
                        $pdo->refuserLigneFraisHorsForfait((int) $id);
                    } else {
                        //si le frais est reporté
                        if ($etat == 'reporte') {
                            //verifier si ficheFrais du mois suivant existe
                            $moisSuivant = DateGsb::definirMoisSuivant($mois);
                            $fiche = $pdo->ficheExiste($idVisiteur, $moisSuivant, 'CR');
                            //si la fichefrais du mois suivant n'existe pas
                            if (!$fiche) {
                                //creer la nouvelle fiche de frais du mois suivant
                                $pdo->creeNouvellesLignesFrais($idVisiteur, $moisSuivant);
                            }
                            //deplacer la ligne fraishorsforfait du mois traité 
                            //vers mois suivant
                            $pdo->creeNouveauFraisHorsForfait($idVisiteur, $moisSuivant, 
                                                              $libelle, $date, $montant);
                            //et supprimer l'ancienne ligne fraishorsforfait
                            $pdo->supprimerFraisHorsForfait((int) $id);
                            //si le frais est validé on y ajoute le montant 
                        } else {
                            $montantValide += $montant;
                        }
                    }
                }
                //enfin on cloture fiche de frais
                $nbJustificatifs = Session::implementer('justificatifs');
                if(FiltreCtrl::estEntierPositif($nbJustificatifs)){
                    $pdo->majMontantFicheFrais($idVisiteur, $mois, $montantValide, 
                                               $nbJustificatifs);
                    $pdo->majEtatFicheFrais($idVisiteur, $mois, 'VA');
                }else {
                    Err::ajouterErreur("Les valeurs des frais doivent être numériques");
                    require("vues/v_erreurs.inc.php");
                }   
            } else {
                Err::ajouterErreur("Les valeurs des frais doivent être numériques");
                require("vues/v_erreurs.inc.php");
            } 
            break;
        }
} 