<?php

require("vues/v_sommaireComptable.inc.php");
$action = implementer('action');

switch ($action) {
    case 'choixFicheValide': {
            //recupération des fiches frais  en etat VA
            $fichesFraisVA = $pdo->obtenirFichesFrais('VA');
            //recuperer infos utiles dans un tableau
            $tabInfoUtiles = array();
            $i = 0;
            foreach ($fichesFraisVA as $fiche) {
                $mois=$fiche['mois'];
                $visiteur=$fiche['idVisiteur'];
                $montantHF=$pdo->getCumulFraisHorsForfait($mois,$visiteur);
                $montantFraisForfait=$pdo->getCumulFraisForfait($mois,$visiteur);              
                $tabInfoUtiles[$i]['fraisForfait'] = $montantFraisForfait;
                $tabInfoUtiles[$i]['fraisHorsForfait'] = $montantHF ;
                $tabInfoUtiles[$i]['montantTotal'] = (float)$fiche['montantValide'];           
                $tabInfoUtiles[$i]['id'] = $visiteur;
                $tabInfoUtiles[$i]['mois'] = $mois;
                $tabInfoUtiles[$i]['nom'] = $pdo->obtenirNomVisiteur($visiteur);
                $tabInfoUtiles[$i]['alerte']='default';
                //verification cohérences des montants (multiplication par 1000
                // pour eviter les bugs liés aux types float )
                if(($tabInfoUtiles[$i]['montantTotal'])*1000 != $montantFraisForfait*1000+$montantHF*1000){
                    $tabInfoUtiles[$i]['alerte']="danger";
                }
                $i++;
            }
            require 'vues/v_suivrePaiement.inc.php';
            break;
        }
    case 'payerFicheFrais': {
            if (!empty($_REQUEST['choix'])) {
                $choix = implementer('choix');
                $etat = 'RB';
                foreach ($choix as $el) { 
                    //recuperation de l'id et du mois afin de lancer une procedure 
                    //de remboursemnt sur base de donnee
                    $tab = array();
                    $tab = explode("-", $el);
                    $id = $tab[0];
                    $mois = $tab[1];
                    $pdo->majEtatFicheFrais($id, $mois, $etat);
                }
                require('vues/v_remboursement.inc.php');
            } else {
                Err::ajouterErreur("aucune fiche remboursée");
                require("vues/v_erreurs.inc.php");                
            }
            break;
        }
} 