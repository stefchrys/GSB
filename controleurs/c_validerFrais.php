<?php
 include ("vues/v_sommaireC.php");
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
       
            //////////////////////traitement frais forfait//////////////////////////
            //tableau de frais forfait idFrais=>quantité
            $lesFrais = implementer('fraisForfait');          
            $mois = implementer('mois');
            $idVisiteur = implementer('visiteur');          
            //mise a jour de ligneFraisForfait
            $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
            $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
            //calcul du montant valide composé des frais forfait
            $montantValide=$pdo->sommeFrais($lesFraisForfait);  
            
            //////////////////traitement des frais hors forfaits /////////////////
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
                       
             //tableau associatif de frais hors forfait numeroté par id de frais
            //      [id][libelle]=>value
            //          [date]   =>value
            //          [montant]=>value
            $tableauFraisHF = [];           
            //remplir tableauFrais  
            foreach ($lesFraisHorsForfait as $frais) {
                $tableauFraisHF[$frais['id']]['libelle'] = $frais['libelle'];
                $tableauFraisHF[$frais['id']]['date'] = $frais['date'];
                $tableauFraisHF[$frais['id']]['montant'] = $frais['montant'];
            }
            //tableau des etats des frais hors forfait idFrais=>etat(validé/reporté/supprimé)
            $etat = implementer('etatFraisHorsForfait');
            //chaque clé correspond à un id de frais hors forfait
            $lesClesEtat = array_keys($etat);
            foreach ($lesClesEtat as $cle) {
                $libelle = $tableauFraisHF[$cle]['libelle'];
                $date = $tableauFraisHF[$cle]['date'];
                $montant = (float) $tableauFraisHF[$cle]['montant'];
                //si on supprime le frais
                if ($etat[$cle] == 'supprime') {
                    //on refuse le paiement
                    $pdo->refuserLigneFraisHorsForfait($cle);
                } else {
                    //si on reporte le frais
                    if ($etat[$cle] == 'reporte') {
                        //verifier si ficheFrais du mois suivant existe
                        $moisSuivant = definirMoisSuivant($mois);
                        $fiche = $pdo->ficheExiste($idVisiteur, $moisSuivant, 'CR');
                        //si la fichefrais du mois suivant n'existe pas
                        if (!$fiche) {
                            //creer la nouvelle fiche de frais du mois suivant
                            $pdo->creeNouvellesLignesFrais($idVisiteur, $moisSuivant);
                        }
                        //deplacer la ligne fraishorsforfait du mois traité vers mois suivant
                        $pdo->creeNouveauFraisHorsForfait($idVisiteur, $moisSuivant, 
                                $libelle, $date, $montant);
                        //et supprimer l'ancienne
                        $pdo->supprimerFraisHorsForfait($cle);
                    //si le frais est validé on y ajoute le montant 
                    }else{
                        $montantValide += $montant;
                    }
                }
            }
            //enfin on cloture fiche de frais
            $nbJustificatifs=implementer('justificatifs');
            $pdo->majMontantFicheFrais($idVisiteur, $mois,$montantValide,$nbJustificatifs);
            $pdo->majEtatFicheFrais($idVisiteur, $mois, 'VA');           
        }
} 