<?php

/**
 * Vérifie que le tableau de frais ne contient que des valeurs numériques 

 * @param array $lesFrais 
 * @return bool true false
 */
function lesQteFraisValides($lesFrais) {
    return TypeNum::estTableauEntiers($lesFrais);
}
/**
 * Filtre  une chaine de carractère
 * @param String $chaine Chaine a filtrer
 * 
 * return int  0 si pas trouvé
 */
function filtrage($chaine){ 
    return preg_match("#[\!%;\|\.&<>]#",$chaine);  
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
        Err::ajouterErreur("Le champ date ne doit pas être vide");
    } else {
        if (!DateGsb::estDateValide($dateFrais)) {
            Err::ajouterErreur("Format Date invalide la date doit être au format jj/mm/aaaa");
        } else {
            if (DateGsb::estDateDepassee($dateFrais)) {
                Err::ajouterErreur("date non valide enregistrement du frais dépassé, plus de 1 an");
            }else {
                if(DateGsb::estDatePosterieur($dateFrais)){
                   Err::ajouterErreur("La date ne doit pas être posterieur à celle du jour courant");
                }              
            }
        }
    }
    //protection libelle contre injection
    if(filtrage($libelle) === 1){//si filtre est sale
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



function remplirTableauFrais($idFrais) {
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
 * Securise l'utilisation des variables globales
 * 
 * @param string $value
 * @return string
 */
function implementer($value) {  
    if (isset($_REQUEST[$value])) {
        $action = $_REQUEST[$value];
        if (!is_array($action)){
            $action = htmlspecialchars($action, ENT_QUOTES);
        }
       
        return $action;
    }else{
        echo "probleme de variable globale".$value;
    }    
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
function fusionner($lesFraisHorsForfait, $etat) {
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



