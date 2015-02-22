<?php

/**
 * Description of TypeNum
 * Classe qui controle les données
 *
 * @author chrysinus@gmail.com
 * @package Filtre
 * @date 20/02/2015
 */
abstract class FiltreCtrl {

    /**
     * Indique si une valeur est un entier positif ou nul

     * @param numeric $valeur
     * @return bool true false
     */
    static function estEntierPositif($valeur) {
        return preg_match("/[^0-9]/", $valeur) == 0;
    }

    /**
     * Indique si un tableau de valeurs est constitué d'entiers positifs ou nuls

     * @param array $tabEntiers : le tableau
     * @return bool true false
     */
    static function estTableauEntiers($tabEntiers) {
        $ok = true;
        foreach ($tabEntiers as $unEntier) {
            if (!self::estEntierPositif($unEntier)) {
                $ok = false;
            }
        }
        return $ok;
    }

    /**
     * Filtre  une chaine de carractère
     * @param String $chaine Chaine a filtrer
     * 
     * return int 1 = trouvé  0 = pas trouvé
     */
    static function prohiberChar($chaine) {
       return preg_match("#[\!%\|\.<>]#", $chaine);
       
    }

    /**
     * Vérifie la validité des trois arguments : la date, le libellé
     *  du frais et le montant 

     * Des message d'erreurs sont ajoutés au tableau des erreurs

     * @param date $dateFrais Date à vérifier
     * @param String $libelle Libellé à vérifier
     * @param Numeric $montant Montant a vérifier
     */
    static function valideInfosFrais($dateFrais, $libelle, $montant) {
        if ($dateFrais == "") {
            Err::ajouterErreur("Le champ date ne doit pas être vide");
        } else {
            if (!DateGsb::estDateValide($dateFrais)) {
                Err::ajouterErreur("Format Date invalide la date doit être au format jj/mm/aaaa");
            } else {
                if (DateGsb::estDateDepassee($dateFrais)) {
                    Err::ajouterErreur("date non valide enregistrement du frais dépassé, plus de 1 an");
                } else {
                    if (DateGsb::estDatePosterieur($dateFrais)) {
                        Err::ajouterErreur("La date ne doit pas être posterieur à celle du jour courant");
                    }
                }
            }
        }
        //protection libelle contre injection
        if (FiltreCtrl::prohiberChar($libelle) === 1) {//si filtre est sale
            Err::ajouterErreur('Carractères interdits!');
        }

        if ($libelle == "") {
            Err::ajouterErreur("Le champ description ne peut pas être vide");
        }
        if ($montant == "") {
            Err::ajouterErreur("Le champ montant ne peut pas être vide");
        } else
        if (!is_numeric($montant)) {
            Err::ajouterErreur("Le champ montant doit être numérique");
        }
    }

}
