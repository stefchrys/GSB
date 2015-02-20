<?php

/**
 * Description of TypeNum
 * Classe qui analyse le type de nombre (entier, float etc)
 *
 * @author chrysinus@gmail.com
 * @package classe.inc
 * @date 20/02/2015
 */
abstract class TypeNum {

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
}


