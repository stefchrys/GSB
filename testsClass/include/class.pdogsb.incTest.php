<?php
require '../../include/class.pdogsb.inc.php';
/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-12-15 at 13:07:03.
 */
class PdoGsbTest extends PHPUnit_Framework_TestCase {

    /**
     * @var PdoGsb
     */
    public $object ;

    /**
     * Construction de l'objet
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = PdoGsb::getPdoGsb();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }
    public function testExecuterRequete(){
        $req="select * from visiteur where if='f4' and mois = '201411'";
        $this->assertEquals($this->object->executerRequete($req,'fetchAll()'),'');
    }
    /**
     * @covers PdoGsb::_destruct
     */
    public function test_destruct() {
        // verification que l'objet est bien detruit
        $this->assertEquals($this->object->_destruct(), null);
    }

    /**
     * @covers PdoGsb::getPdoGsb
     * verifie les propriété de l'objet
     */
    public function testGetPdoGsb() {
        $this->assertEquals('mysql:host=localhostdbname=gsbv3root',
                $this->object->obtenirProprietes());
    }

    /**
     * @covers PdoGsb::obtenirInfoVisiteur
     * @todo   Implement testObtenirInfoVisiteur().
     */
    public function testObtenirInfoVisiteur() {
        // Remove the following lines when you implement this test.
       
    }

    /**
     * @covers PdoGsb::obtenirListeVisiteurs
     * @todo   Implement testObtenirListeVisiteurs().
     */
    public function testObtenirListeVisiteurs() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::obtenirLesFraisHorsForfait
     * @todo   Implement testObtenirLesFraisHorsForfait().
     */
    public function testObtenirLesFraisHorsForfait() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::obtenirLesFraisForfait
     * @todo   Implement testObtenirLesFraisForfait().
     */
    public function testObtenirLesFraisForfait() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::obtenirLesIdFrais
     * @todo   Implement testObtenirLesIdFrais().
     */
    public function testObtenirLesIdFrais() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::verifierComptable
     * @todo   Implement testVerifierComptable().
     */
    public function testVerifierComptable() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::majFraisForfait
     * @todo   Implement testMajFraisForfait().
     */
    public function testMajFraisForfait() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::estPremierFraisMois
     * @todo   Implement testEstPremierFraisMois().
     */
    public function testEstPremierFraisMois() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::dernierMoisSaisi
     * @todo   Implement testDernierMoisSaisi().
     */
    public function testDernierMoisSaisi() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::creeNouvellesLignesFrais
     * @todo   Implement testCreeNouvellesLignesFrais().
     */
    public function testCreeNouvellesLignesFrais() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::creeNouveauFraisHorsForfait
     * @todo   Implement testCreeNouveauFraisHorsForfait().
     */
    public function testCreeNouveauFraisHorsForfait() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::supprimerFraisHorsForfait
     * @todo   Implement testSupprimerFraisHorsForfait().
     */
    public function testSupprimerFraisHorsForfait() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::obtenirLesMoisDisponibles
     * @todo   Implement testObtenirLesMoisDisponibles().
     */
    public function testObtenirLesMoisDisponibles() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::obtenirLesInfosFicheFrais
     * @todo   Implement testObtenirLesInfosFicheFrais().
     */
    public function testObtenirLesInfosFicheFrais() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::majEtatFicheFrais
     * @todo   Implement testMajEtatFicheFrais().
     */
    public function testMajEtatFicheFrais() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::majMontantFicheFrais
     * @todo   Implement testMajMontantFicheFrais().
     */
    public function testMajMontantFicheFrais() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::getDouzeMois
     * @todo   Implement testGetDouzeMois().
     */
    public function testGetDouzeMois() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::ficheExiste
     * @todo   Implement testFicheExiste().
     */
    public function testFicheExiste() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::changerLibelle
     * @todo   Implement testChangerLibelle().
     */
    public function testChangerLibelle() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::verifierTailleLibelle
     * @todo   Implement testVerifierTailleLibelle().
     */
    public function testVerifierTailleLibelle() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::refuserLigneFraisHorsForfait
     * @todo   Implement testRefuserLigneFraisHorsForfait().
     */
    public function testRefuserLigneFraisHorsForfait() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::valeurMontant
     * @todo   Implement testValeurMontant().
     */
    public function testValeurMontant() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::obtenirFichesFrais
     * @todo   Implement testObtenirFichesFrais().
     */
    public function testObtenirFichesFrais() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::sommeFrais
     * @todo   Implement testSommeFrais().
     */
    public function testSommeFrais() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::obtenirNomVisiteur
     * @todo   Implement testObtenirNomVisiteur().
     */
    public function testObtenirNomVisiteur() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::getCumulFraisHorsForfait
     * @todo   Implement testGetCumulFraisHorsForfait().
     */
    public function testGetCumulFraisHorsForfait() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

    /**
     * @covers PdoGsb::getCumulFraisForfait
     * @todo   Implement testGetCumulFraisForfait().
     */
    public function testGetCumulFraisForfait() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
                'This test has not been implemented yet.'
        );
    }

}