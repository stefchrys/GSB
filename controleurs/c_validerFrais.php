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
            $mois = implementer('mois');
            $idVisiteur = implementer('visiteur');
            //mettre a jour table lignefraisforfait
            $idFrais = $pdo->getLesIdFrais();
            $lesFrais = remplirTableauFrais($idFrais);
            $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
            //mettre a jour table lignefraishorsforfait
            $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
            $i = 0;
            foreach ($lesFraisHorsForfait as $value) {
                $idFrais = implementer('idFraisHorsForfait', (string) $i);
                $etatFrais = implementer('etatFraisHorsForfait', (string) $i);

                if ($etatFrais == 'supprime') {
                    //supprime ligne de etat frais ou id=idFrais
                    echo "sup";
                } else
                if ($etatFrais == 'reporte') {
                    //reporter la ligne de frais sur mois suivant
                    echo "ref";
                }
            }
            //Faire les comptes et valider ficheFrais
        }
}