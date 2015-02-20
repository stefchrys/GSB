<?php

/**
 * Description of DateGsb
 * Classe de manipulation des dates
 * @author chrysinus@gmail.com
 * @package classe.inc
 * @date 20/02/2015
 */
abstract class DateGsb {

    /**
     * Convertisseur de date FR->UK

     * Transforme une date au format français jj/mm/aaaa vers le format
     * anglais aaaa-mm-jj
     * @param date $maDate  Date au format  jj/mm/aaaa
     * @return date Date au format anglais aaaa-mm-jj
     */
    static function dateFrancaisVersAnglais($maDate) {
        list($jour, $mois, $annee) = explode('/', $maDate);
        $retour = date('Y-m-d', mktime(0, 0, 0, $mois, $jour, $annee));
        return $retour;
    }

    /**
     * Convertisseur de date UK->FR

     * Transforme une date au format format anglais aaaa-mm-jj vers 
     * le format français jj/mm/aaaa 
     * @param date $maDate Date au format  aaaa-mm-jj
     * @return date Date au format format français jj/mm/aaaa
     */
    static function dateAnglaisVersFrancais($maDate) {
        list($annee, $mois, $jour) = explode('-', $maDate);
        $date = "$jour" . "/" . $mois . "/" . $annee;
        return $date;
    }

    /**
     * Simplifie le format d'une date

     * Retourne le mois au format aaaamm selon le jour dans le mois
     * @param date $date  Format  jj/mm/aaaa
     * @return date Mois au format aaaamm
     */
    static function getMois($date) {
        list($jour, $mois, $annee) = explode('/', $date);
        if (strlen($mois) == 1) {
            $mois = "0" . $mois;
        }
        return $annee . $mois;
    }

    /**
     * Calcul si la date envoyée en paramètre est posterieur à la date actuelle
     * renvoi vrai si elle est posterieur
     * 
     * @param date $date
     * @return bool 
     */
    static function estDatePosterieur($date) {
        $dateActuelle = date("Y-m-d");
        $dateFormatee = DateGsb::dateFrancaisVersAnglais($date);
        return($dateFormatee > $dateActuelle);
    }

    /**
     * Vérifie si une date est inférieure d'un an à la date actuelle

     * @param date $dateTestee  Date à tester
     * @return bool true false
     */
    static function estDateDepassee($dateTestee) {
        $dateActuelle = date("d/m/Y");
        list($jour, $mois, $annee) = explode('/', $dateActuelle);
        $annee--;
        $AnPasse = $annee . $mois . $jour;
        list($jourTeste, $moisTeste, $anneeTeste) = explode('/', $dateTestee);
        return ($anneeTeste . $moisTeste . $jourTeste < $AnPasse);
    }

    /**
     * Vérifie la validité du format d'une date française jj/mm/aaaa 

     * @param date $date Date à Vérifier
     * @return bool true false
     */
    static function estDateValide($date) {
        $tabDate = explode('/', $date);
        $dateOK = true;
        if (strlen($date) != 10) {
            $dateOK = false;
        }
        if (count($tabDate) != 3) {
            $dateOK = false;
        } else {
            if (!TypeNum::estTableauEntiers($tabDate)) {
                $dateOK = false;
            } else {
                if (!checkdate($tabDate[1], $tabDate[0], $tabDate[2])) {
                    $dateOK = false;
                }
            }
        }
        return $dateOK;
    }

    /**
     * Definit le mois suivant une date donnée en parametre au format
     * aaaamm
     * 
     * @param string $date Date au format aaaamm
     * @return string Renvoie une date au format aaaamm
     */
    static function definirMoisSuivant($date) {
        $moisSuivant = "";
        $annee = substr($date, 0, 4);
        $mois = substr($date, 4, 2);
        //si le mois est 12 alors le prochain est 01, et l'année avance d'un cran
        if ((int) $mois == 12) {
            $mois = 1;
            (int) $annee++;
        } else {
            $mois++;
        }
        //on formate le mois en 'mm' 
        if ($mois < 10) {
            (string) $mois = '0' . (string) $mois;
        }
        $moisSuivant = (string) $annee . (string) $mois;
        return $moisSuivant;
    }

    /**
     * Convertit un mois numerique en chaine de carractères
     * 
     * @param $mois int
     * return string
     */
    static function moisChaine($mois) {
        $tabMois = Array('Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet',
            'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre');
        if ($mois <= 0 || $mois > 12) {
            echo 'Entrer un nombre compris entre 1 et 12';
            return null;
        }
        $mois--; // -1 car un tableau de 12 mois va de 0 a 11  :)
        return $tabMois[$mois];
    }

}
