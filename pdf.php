<?php 
require_once ("include/class.PDF.inc.php");
require_once("include/class.ManierTableaux.inc.php");

//////////////////////////////////////////////////
//creation de tableau de données frais forfait
///////////////////////////////////////////////////
$headerFraisForfait = array('Frais Forfaitaires','Quantité','Montant unitaire','Total');
//recuperation chaine de carractères
$txtCharFf = $_REQUEST['txtFilePdfFraisForfait'];
//sous division en tableau associatif en 4
 $fraisForfait = ManierTableaux::textToArray($txtCharFf, 4);
 
//////////////////////////////////////////////////////////////////
//creation de tableau de données frais hors forfait(meme principe)
 //////////////////////////////////////////////////////////////////
$headerFraisHorsForfait = array('Date','Frais Hors-Forfait','Montant');
$txtCharFhf = $_REQUEST['txtFilePdfFraisHorsForfait'];
$fraisHorsForfait = ManierTableaux::textToArray($txtCharFhf, 3);

/////////////////////////////////////////
//creation tableau resumé situation
/////////////////////////////////////////
$headerResume = array('Date traitement','Etat','Nb justificatifs','Montant');
$txtFilePdfResume = $_REQUEST['txtFilePdfResume'];
$dataResume[] = explode('!',trim($txtFilePdfResume));

//creation periode
$txtFilePdfMois = $_REQUEST['txtFilePdfMois'];


$size = 7;//taille de la hauteur de cellule    
$pdf = new PDF();
$pdf->AliasNbPages();//compteur de page pour le footer
$monTitre = 'Situation '.$txtFilePdfMois;//creation du titre
$pdf->SetTitle($monTitre);
//reglage général
$pdf->SetFont('Arial','',10);
$pdf->AddPage();// ne pas oublier d'ajouter une page

//affichage entete FF
$pdf->imprimFraisForfait($headerFraisForfait,$fraisForfait,$size);
//affichage Frais hors forfait
$pdf->imprimFraisHorsForfait($headerFraisHorsForfait,$fraisHorsForfait,$size);
//affichage resumé
$pdf->imprimResume($headerResume,$dataResume,$size);





