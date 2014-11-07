﻿<?php
/**
 * Fonctions pour l'application GSB

 * Fonctions Metier (MODELE)
 *  
 * @author chrysinus@gmail.com
 * 
 */

/**
 * Teste si un quelconque visiteur est connecté
 * @return bool true false
 */
function estConnecte() {
    return isset($_SESSION['idVisiteur']);
}

/**
 * Enregistre dans une variable session les infos d'un visiteur

 * @param $id 
 * @param $nom
 * @param $prenom
 */
function connecter($id, $nom, $prenom) {
    $_SESSION['idVisiteur'] = $id;
    $_SESSION['nom'] = $nom;
    $_SESSION['prenom'] = $prenom;
}

/**
 * Détruit la session active
 */
function deconnecter() {
    session_destroy();
}

/**
 * Convertisseur de date FR->UK

 * Transforme une date au format français jj/mm/aaaa vers le format
 * anglais aaaa-mm-jj
 * @param date $maDate  Date au format  jj/mm/aaaa
 * @return date Date au format anglais aaaa-mm-jj
 */
function dateFrancaisVersAnglais($maDate) {
    list($jour, $mois, $annee) = explode('/', $maDate);
    return date('Y-m-d', mktime(0, 0, 0, $mois, $jour, $annee));
}

/**
 * Convertisseur de date UK->FR

 * Transforme une date au format format anglais aaaa-mm-jj vers 
 * le format français jj/mm/aaaa 
 * @param date $maDate Date au format  aaaa-mm-jj
 * @return date Date au format format français jj/mm/aaaa
 */
function dateAnglaisVersFrancais($maDate) {
    list($annee, $mois, $jour) = explode('-', $maDate);
    $date = "$jour" . "/" . $mois . "/" . $annee;
    return $date;
}

/**
 * Simplifie le format d'une date

 * retourne le mois au format aaaamm selon le jour dans le mois
 * @param date $date  Format  jj/mm/aaaa
 * @return date Mois au format aaaamm
 */
function getMois($date) {
    list($jour, $mois, $annee) = explode('/', $date);
    if (strlen($mois) == 1) {
        $mois = "0" . $mois;
    }
    return $annee . $mois;
}

/* gestion des erreurs */

/**
 * Indique si une valeur est un entier positif ou nul

 * @param numeric $valeur
 * @return bool true false
 */
function estEntierPositif($valeur) {
    return preg_match("/[^0-9]/", $valeur) == 0;
}

/**
 * Indique si un tableau de valeurs est constitué d'entiers positifs ou nuls

 * @param array $tabEntiers : le tableau
 * @return bool true false
 */
function estTableauEntiers($tabEntiers) {
    $ok = true;
    foreach ($tabEntiers as $unEntier) {
        if (!estEntierPositif($unEntier)) {
            $ok = false;
        }
    }
    return $ok;
}

/**
 * Vérifie si une date est inférieure d'un an à la date actuelle

 * @param date $dateTestee  Date à tester
 * @return bool true false
 */
function estDateDepassee($dateTestee) {
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
function estDateValide($date) {
    $tabDate = explode('/', $date);
    $dateOK = true;
    if (count($tabDate) != 3) {
        $dateOK = false;
    } else {
        if (!estTableauEntiers($tabDate)) {
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
 * Vérifie que le tableau de frais ne contient que des valeurs numériques 

 * @param array $lesFrais 
 * @return bool true false
 */
function lesQteFraisValides($lesFrais) {
    return estTableauEntiers($lesFrais);
}

/**
 * Vérifie la validité des trois arguments : la date, le libellé
 *  du frais et le montant 

 * Des message d'erreurs sont ajoutés au tableau des erreurs

 * @param date $dateFrais Date à vérifier
 * @param String $libelle Libellé à vérifier
 * @param Numeric $montant Montant a vérifier
 */
function valideInfosFrais($dateFrais, $libelle, $montant) {
    if ($dateFrais == "") {
        ajouterErreur("Le champ date ne doit pas être vide");
    } else {
        if (!estDatevalide($dateFrais)) {
            ajouterErreur("Date invalide");
        } else {
            if (estDateDepassee($dateFrais)) {
                ajouterErreur("date d'enregistrement du frais dépassé, plus de 1 an");
            }
        }
    }
    if ($libelle == "") {
        ajouterErreur("Le champ description ne peut pas être vide");
    }
    if ($montant == "") {
        ajouterErreur("Le champ montant ne peut pas être vide");
    } else
    if (!is_numeric($montant)) {
        ajouterErreur("Le champ montant doit être numérique");
    }
}

/**
 * Ajoute le libellé d'une erreur au tableau des erreurs 

 * @param String $msg : le libellé de l'erreur 
 */
function ajouterErreur($msg) {
    if (!isset($_REQUEST['erreurs'])) {
        $_REQUEST['erreurs'] = array();
    }
    $_REQUEST['erreurs'][] = $msg;
}

/**
 * Retoune le nombre de lignes du tableau des erreurs 

 * @return int Le nombre d'erreurs
 */
function nbErreurs() {
    if (!isset($_REQUEST['erreurs'])) {
        return 0;
    } else {
        return count($_REQUEST['erreurs']);
    }
}

function remplirTableauFrais($idFrais) {
    $lesFrais = array();
    for ($i = 0; $i < count($idFrais); $i++) {
        if (isset($_REQUEST['fraisForfait' . $i]) && is_string($_REQUEST['fraisForfait' . $i])) {
            $lesFrais[$idFrais[$i][0]] = (int) (($_REQUEST['fraisForfait' . $i]));
        }
    }
    return $lesFrais;
}
/**
 * Securise l'utilisation des variables globales
 * 
 * @param string $value
 * @return string
 */
function implementer($value) {
    $action = "";
    if (isset($_REQUEST[$value])) {
        $action = $_REQUEST[$value];
        return $action;
    }else{
        echo "probleme de variable globale".$value;
    }
    
}

?>