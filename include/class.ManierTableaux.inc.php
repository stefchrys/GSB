<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ManierTableaux
 *
 * @author Stef
 */
abstract class ManierTableaux {

    /**
     * 
     * Fusionne 2 tableaux associatifs afin de renvoyer un tableau associatif avec juste 
     * les infos necessaires.
     * id devient la clé .
     * exemple:
     * $tab1=[0=>'id','idVisiteur','mois','libelle','date','montant']
     * $tab2=['id'=>'etat']
     * fusionner($tab1,$tab2) = ['id'=>'id','libelle','date','montant','etat']
     * 
     * 
     *    1er tableau           2eme tableau        tableau fusionné
     *    clé|Value             clé|Value           clé|Value
     *  -----+---------         ---+-----           ---+-----
     * index |id                id | etat           id | id
     *       |idVisiteur                               |libelle
     *       |mois                                     |date
     *       |libelle                                  |montant
     *       |date                                     |etat
     *       |montant
     * 
     * @param array $lesFraisHorsForfait tableau de frais hors forfait
     * @param array $etat tableau des etat type id=>etat
     * @return array
     */
    static function fusionner($lesFraisHorsForfait, $etat) {
        $tableauFraisHF = [];
        //remplir tableauFrais  
        foreach ($lesFraisHorsForfait as $frais) {
            $index = $frais['id'];
            $tableauFraisHF[$index]['id'] = $frais['id'];
            $tableauFraisHF[$index]['libelle'] = $frais['libelle'];
            $tableauFraisHF[$index]['date'] = $frais['date'];
            $tableauFraisHF[$index]['montant'] = $frais['montant'];
            $tableauFraisHF[$index]['etat'] = $etat[$frais['id']];
        }
        return $tableauFraisHF;
    }

    /**
     * Transforme un texte serialisé en tableaux associatif .
     * 
     * @param string $text Ensemble de mots séparés par le carractère "!"
     * @param int $cols Nombre de colonnes prévues
     * @return array Tableau composé $cols colonnes et rempli par les motsde $text
     * Si le nombre de colonnes n'est pas un multiple du nombre d'elemnt retourne NULL
     * 
     */
    static function textToArray($text, $cols) {
        $textArray[] = explode('!', trim($text));
        $indice = 0;
        $array = array();
        if (count($textArray[0]) % $cols == 0) {
            $val = (count($textArray[0]) / $cols);
            for ($i = 0; $i < $val; $i++) {
                for ($j = 0; $j < $cols; $j++) {
                    $array[$i][$j] = $textArray[0][$indice];
                    $indice++;
                }
            }
            return $array;
        } else {
            return null;
        }
    }

}
