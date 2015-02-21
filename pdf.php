<?php 
require_once ("include/class.PDF.inc.php");

//creation des tableau de données frais forfait
$headerFraisForfait = array('Frais Forfaitaires','Quantité','Montant unitaire','Total');
//recuperation chaine de carractères
$txtCharFf = $_REQUEST['txtFilePdfFraisForfait'];
//sous division en tableau associatif en 4
$dataFraisForfait[] = explode('!',trim($txtCharFf));
$indice=0;
$fraisForfait = array();
$val=(count($dataFraisForfait[0])/4);
for($i=0;$i<$val;$i++){
    for($j=0;$j<4;$j++){
        $fraisForfait[$i][$j]=$dataFraisForfait[0][$indice];
        $indice++;
    }
}
//creation des tableau de données frais hors forfait(meme principe)
$headerFraisHorsForfait = array('Date','Frais Hors-Forfait','Montant');
$txtCharFhf = $_REQUEST['txtFilePdfFraisHorsForfait'];
$dataFraisHorsForfait[] = explode('!',trim($txtCharFhf));
$indices=0;
$fraisHorsForfait = array();
$val=(count($dataFraisHorsForfait[0])/3);
for($i=0;$i<$val;$i++){
    for($j=0;$j<3;$j++){
        $fraisHorsForfait[$i][$j]=$dataFraisHorsForfait[0][$indices];
        $indices++;
    }
}

//creation tableau resumé situation
$headerResume = array('Date traitement','Etat','Nb justificatifs','Montant');
$txtFilePdfResume = $_REQUEST['txtFilePdfResume'];
$dataResume[] = explode('!',trim($txtFilePdfResume));

//creation periode
$txtFilePdfMois = $_REQUEST['txtFilePdfMois'];


$size = 7;    
$pdf = new PDF();
//appel titre
$monTitre = 'Situation '.$txtFilePdfMois;
$pdf->SetTitle($monTitre);
//reglage général
$pdf->SetFont('Arial','',10);
$pdf->AddPage();

//affichage entete FF
$pdf->imprimFraisForfait($headerFraisForfait,$fraisForfait,$size);
//affichage Frais hors forfait
$pdf->imprimFraisHorsForfait($headerFraisHorsForfait,$fraisHorsForfait,$size);
//affichage resumé
$pdf->imprimResume($headerResume,$dataResume,$size);





