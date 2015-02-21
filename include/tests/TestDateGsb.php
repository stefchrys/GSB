<?php

/**
 * Description of TestTypeNum
 * @package Test_Unitaire
 * @author Stef 
 */

require_once ("../class.DateGsb.inc.php");
class TestDateGsb extends PHPUnit_Framework_TestCase {
 
    public function testDateGsbClass(){
        $dateFr = "29/03/2014";
        $dateUk = "2014-03-29";
        $moisUk = "201403";
        //dateFrancaisVersAnglais
        $this->assertEquals($dateUk, DateGsb::dateFrancaisVersAnglais($dateFr));
        //dateAnglaisVersFrancais
        $this->assertEquals($dateFr, DateGsb::dateAnglaisVersFrancais($dateUk));
        //getMois
        $this->assertEquals( $moisUk,  DateGsb::getMois($dateFr));
        //estDatePosterieur
        $this->assertEquals( false,  DateGsb::estDatePosterieur($dateFr));
        //estDateDepassee
        $this->assertEquals( false,  DateGsb::estDateDepassee($dateFr));
        //estDateValide
        $this->assertEquals( true,  DateGsb::estDateValide($dateFr));
        $arr=["jj/mm/aaaa","00/00/0000","foo","2014/02/02","","02/02/20145"];
        foreach ($arr as $el) {
            $this->assertEquals( false,  DateGsb::estDateValide($el)); 
        }
        //definirMoisSuivant
        $arrMois=["201412"=>"201501","201401"=>"201402"];
        foreach($arrMois as $key=>$value){
            $this->assertEquals( $value,  DateGsb::definirMoisSuivant($key));
        }
        //moisChaine
        $tabMois =['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet',
            'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'];
        $count = 1;
        foreach($tabMois as $el){           
             $this->assertEquals( $el,  DateGsb::moisChaine($count));
            $count++;
        }
        $this->assertEquals( null,  DateGsb::moisChaine(0));
        $this->assertEquals( null,  DateGsb::moisChaine(13));
       

    }
}

