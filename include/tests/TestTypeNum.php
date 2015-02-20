<?php

/**
 * Description of TestTypeNum
 * @package Test_Unitaire
 * @author Stef 
 */
require_once ("../class.TypeNum.inc.php");
class TestTypeNum extends PHPUnit_Framework_TestCase {
    
    public function testEstEntierPositif(){
        
        $this->assertEquals(1,TypeNum::estEntierPositif(1));
        $this->assertEquals(null,TypeNum::estEntierPositif(1.2));
        $this->assertEquals(null,TypeNum::estEntierPositif("foo"));
        
        $arr = [1,2,3];
        $this->assertEquals(true ,TypeNum::estTableauEntiers($arr));
        
         $arr = [1,"foo",3];
        $this->assertEquals(false ,TypeNum::estTableauEntiers($arr));
    }
}
