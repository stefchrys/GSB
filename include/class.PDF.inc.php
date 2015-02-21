<?php

/**
 * 
 * Classe PDF qui hérite de FPDF
 * 
 * @author chrysinus@gmail.com
 * @package class.inc
 * 
 */
require('class.fpdf.inc.php');

class PDF extends FPDF {

    /**
     * 
     * La function header est surchargée et appelée nativement dans la classe mère
     * Nul besoin de l'appeler elle est chargée directement à l'implementation de la Classe FPDF
     * Elle s'occupe de la mise en place du header on y met tout ce que l'on veut.
     */
    function Header() {
        global $monTitre;
        if ($this->PageNo() == 1) {//entete que sur premiere page
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
            $this->Cell($w, 10, $monTitre, 1, 0, 'C',1);
            // Saut de ligne
            $this->Ln(20);
        }
    }

    /**
     * Même principe que la fonction header .
     */
    function Footer() {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Arial', 'I', 8);
        // Numéro de page
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    /**
     * Crée une grille remplie des données des deux tableaux 
     * 
     * @param array $header Tableaux de string rempli de titres
     * @param array $inner  Tableaux de string rempli des données
     * @param int $size Hauteur cellules
     * @param int $width largeur cellules
     * @param string $entete Titre de l'entete de la grille
     * 
     */
    function imprimContenu($header, $inner, $size,$width,$entete) {
        $this->SetFillColor(200,220,255);
        $this->Cell($width, $size, utf8_decode($entete), 1,0,'L',1);
        $this->Ln();
        // affichage Entete 
        foreach ($header as $col) {
            $this->SetFillColor(230, 230, 0);
            $this->Cell($width, $size, utf8_decode($col), 1,0,'L',1);
        }
        $this->Ln();
        // affichage Données 
        foreach ($inner as $row) {
            foreach ($row as $col)
                $this->Cell($width, $size, utf8_decode($col), 1,0,'L');
            $this->Ln();
        }
        $this->Ln();
    }
}
