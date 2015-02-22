<?php

/**
 * Description of Err
 * Classe de manipulation des Erreurs
 * @author chrysinus@gmail.com
 * @package Erreur
 * @date 20/02/2015
 */
abstract class Err {

    /**
     * Ajoute le libellé d'une erreur au tableau des erreurs 

     * @param String $msg : le libellé de l'erreur 
     */
    static function ajouterErreur($msg) {
        if (!isset($_REQUEST['erreurs'])) {
            $_REQUEST['erreurs'] = array();
        }
        $_REQUEST['erreurs'][] = $msg;
    }

    /**
     * Retoune le nombre de lignes du tableau des erreurs 

     * @return int Le nombre d'erreurs
     */
    static function nbErreurs() {
        if (!isset($_REQUEST['erreurs'])) {
            return 0;
        } else {
            return count($_REQUEST['erreurs']);
        }
    }

}
