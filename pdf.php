<?php 
require_once ("include/class.fpdf.inc.php");

//creation des tableau de données frais forfait
$headerFraisForfait = array('Frais Forfaitaires','Quantité','Montant unitaire','Total');
//recuperation chaine de carractères
$txtCharFf = $_REQUEST['txtFilePdfFraisForfait'];
//sous division en tableau associatif en 4
$dataFraisForfait[] = explode('!',trim($txtCharFf));
//array_pop($dataFraisForfait[0]);//ôte le dernier carractère vide(plus besoin)
$indice=0;
$fraisForfait = array();
$val=(count($dataFraisForfait[0])/4);
for($i=0;$i<$val;$i++){
    for($j=0;$j<4;$j++){
        $fraisForfait[$i][$j]=$dataFraisForfait[0][$indice];
        $indice++;
    }
}
//creation des tableau de données frais forfait(meme principe)
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
$pdf = new FPDF();
$pdf->SetFont('Arial','',10);
$pdf->AddPage();
//affichate periode concernée
$titre = 'Compte rendu Fiche de frais periode : ';
$pdf->Cell(180, $size, ($titre.$txtFilePdfMois), 1);
$pdf->Ln();$pdf->Ln();

// affichage entete FF
$pdf->Cell(45, $size, 'Frais forfaitaires', 1);
$pdf->Ln();
foreach ($headerFraisForfait as $col) {
    $pdf->Cell(45, $size,  utf8_decode($col), 1);
}$pdf->Ln();
// affichage Données FF
foreach ($fraisForfait as $row) {
    foreach ($row as $col)
        $pdf->Cell(45, $size,  utf8_decode($col), 1);
    
    $pdf->Ln();
}

$pdf->Ln();
$pdf->Cell(60, $size, 'Frais hors-forfait', 1);
$pdf->Ln();

// affichage entete Fhf
foreach ($headerFraisHorsForfait as $col) {
    $pdf->Cell(60, $size, $col, 1);
}$pdf->Ln();
// affichage Données Fhf
foreach ($fraisHorsForfait as $row) {
    foreach ($row as $col)
        $pdf->Cell(60, $size,  utf8_decode($col), 1);
    $pdf->Ln();
}$pdf->Ln();


//affichage resumé situation
//entete
foreach ($headerResume as $col) {

    $pdf->Cell(45, $size, $col, 1);
}$pdf->Ln();
//Données
foreach ($dataResume as $row) {

   foreach ($row as $col)
        $pdf->Cell(45, $size,  utf8_decode($col), 1);
    $pdf->Ln();
}$pdf->Ln();
$pdf->Output("FicheFrais.pdf","D");
?>

