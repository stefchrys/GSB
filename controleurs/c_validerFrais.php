<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include("vues/v_sommaireC.php");
$action = $_REQUEST['action'];
$visiteurs = $pdo->getListeVisiteurs();
$tableauDate= $pdo->getDouzeMois();

switch ($action){
    case 'choixVisiteurMois':{
        include('vues/v_listeVisiteurMoisC.php');
        break;
    }
    
    case 'validerChoixVisiteurMois':{
         //controler qu'une fiche de frias existe
        
        //si existe pas retour choixMoisVisiteur
        
        //si fiche existe on affiche la fiche frais correspondante
        break;
    }
        
}