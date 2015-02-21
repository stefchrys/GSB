<?php

require('class.fpdf.inc.php');

class PDF extends FPDF {

// En-tête
    function Header() {
        global $monTitre;
        // Logo
        $this->Image('images/logo.jpg', 10, 6, 30);
        // Police Arial gras 15
        $this->SetFont('Arial', 'B', 15);
        // Décalage à droite
        $this->Cell(80);
        // Calcul de la largeur du titre et positionnement
        $w = $this->GetStringWidth($monTitre) + 6;
        $this->SetX((210 - $w) / 2);
        // Couleurs du cadre, du fond et du texte
        $this->SetDrawColor(0, 80, 180);
        $this->SetFillColor(230, 230, 0);
        $this->SetTextColor(220, 50, 50);
        // Titre
        $this->Cell($w, 10, $monTitre, 1, 0, 'C');
        // Saut de ligne
        $this->Ln(20);
    }

// Pied de page
    function Footer() {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial', 'I', 8);
        // Numéro de page
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
    
    function imprimFraisForfait($header,$inner,$size) {
        // affichage entete FF       
        $this->Cell(45, $size, 'Frais forfaitaires', 1);
        $this->Ln();
        foreach ($header as $col) {
            $this->Cell(45, $size, utf8_decode($col), 1);
        }$this->Ln();
        // affichage Données FF
        foreach ($inner as $row) {
            foreach ($row as $col)
                $this->Cell(45, $size, utf8_decode($col), 1);
            $this->Ln();
        }
    }
    
    function imprimFraisHorsForfait($header,$inner,$size) {
        $this->Ln();
        $this->Cell(60, $size, 'Frais hors-forfait', 1);
        $this->Ln();

        // affichage entete Fhf
        foreach ($header as $col) {
            $this->Cell(60, $size, $col, 1);
        }$this->Ln();
        // affichage Données Fhf
        foreach ($inner as $row) {
            foreach ($row as $col)
                $this->Cell(60, $size, utf8_decode($col), 1);
            $this->Ln();
        }$this->Ln();
    }
    
    function imprimResume($header, $inner,$size) {
        //affichage resumé situation
        //entete
        foreach ($header as $col) {

            $this->Cell(45, $size, $col, 1);
        }$this->Ln();
        //Données
        foreach ($inner as $row) {

            foreach ($row as $col)
                $this->Cell(45, $size, utf8_decode($col), 1);
            $this->Ln();
        }$this->Ln();
        $this->Output();
    }

}
