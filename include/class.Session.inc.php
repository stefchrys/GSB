<?php

/*
 * Classe de Session
 * Classe reservée au manipulations de variables de session
 * @author: chrysinus@gmail.com
 * @package: Session
 * @date: 20/02/2015
 */

abstract class Session {

    /**
     * Teste si un quelconque visiteur est connecté
     * @return bool true false
     */
    static function estConnecte() {
        return isset($_SESSION['idVisiteur']);
    }

    /**
     * Enregistre dans une variable session les infos d'un visiteur

     * @param $id 
     * @param $nom
     * @param $prenom
     */
    static function connecter($id, $nom, $prenom) {
        $_SESSION['idVisiteur'] = $id;
        $_SESSION['nom'] = $nom;
        $_SESSION['prenom'] = $prenom;
    }

    /**
     * Détruit la session active
     */
    static function deconnecter() {
        session_destroy();
    }
    
    /**
     * Securise l'utilisation des variables globales
     * 
     * @param string $value
     * @return string
     */
    static function implementer($value) {
        if (isset($_REQUEST[$value])) {
            $action = $_REQUEST[$value];
            if (!is_array($action)) {
                $action = htmlspecialchars($action, ENT_QUOTES);
            }
            return $action;
        } else {
            echo "probleme de variable globale" . $value;
            return null;
        }
    }

}
