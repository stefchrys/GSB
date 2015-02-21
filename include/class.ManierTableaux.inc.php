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

static function remplirTableauFrais($idFrais) {
    $lesFrais = array();
    for ($i = 0; $i < count($idFrais); $i++) {
        if (isset($_REQUEST['fraisForfait' . $i]) 
                  && is_string($_REQUEST['fraisForfait' . $i])) {
            $lesFrais[$idFrais[$i][0]] = (int) (($_REQUEST['fraisForfait' . $i]));
        }
    }
    return $lesFrais;
}


/**
 * (ok)
 * Fusionne 2 tableaux associatifs afin de renvoyer un tableau associatif avec juste 
 * les infos necessaires.
 * id devient la clé .
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
        $index=$frais['id'];
        $tableauFraisHF[$index]['id'] = $frais['id'];
        $tableauFraisHF[$index]['libelle'] = $frais['libelle'];
        $tableauFraisHF[$index]['date'] = $frais['date'];
        $tableauFraisHF[$index]['montant'] = $frais['montant'];
        $tableauFraisHF[$index]['etat'] = $etat[$frais['id']];
    }
    return $tableauFraisHF;
}




    
}
