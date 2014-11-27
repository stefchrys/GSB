<?php

include("vues/v_sommaireC.php");
$action = implementer('action');

switch ($action) {
    case 'choixFicheValide': {
            //recupération des fiches frais  en etat VA
            $fichesFraisVA = $pdo->getFichesFrais('VA');
            //recuperer infos utiles dans un tableau
            $tabInfoUtiles = array();
            $i = 0;
            foreach ($fichesFraisVA as $fiche) {
                $lesFraisForfait = $pdo->getLesFraisForfait($fiche['idVisiteur'], $fiche['mois']);
                $montantFraisForfait = $pdo->sommeFrais($lesFraisForfait);
                $tabInfoUtiles[$i]['fraisForfait'] = $montantFraisForfait;
                $tabInfoUtiles[$i]['fraisHorsForfait'] = ($fiche['montantValide']) - ($montantFraisForfait);
                $tabInfoUtiles[$i]['montantTotal'] = $fiche['montantValide'];
                $tabInfoUtiles[$i]['id'] = $fiche['idVisiteur'];
                $tabInfoUtiles[$i]['mois'] = $fiche['mois'];
                $tabInfoUtiles[$i]['nom'] = $pdo->getNomVisiteur($fiche['idVisiteur']);
                $i++;
            }
            include 'vues/v_suivrePaiement.php';
            break;
        }
    case 'payerFicheFrais': {
            if (!empty($_REQUEST['choix'])) {
                $choix = implementer('choix');
                $etat = 'RB';
                foreach ($choix as $el) {
                    //recuperation de l'id et du mois afin de lancer une procedure de remboursemnt sur base de donnee
                    $tab = array();
                    $tab = explode("-", $el);
                    $id = $tab[0];
                    $mois = $tab[1];
                    $pdo->majEtatFicheFrais($id, $mois, $etat);
                }
                include('vues/v_remboursement.php');
            } else {
                echo "aucune fiche remboursée";
            }
            break;
        }
} 