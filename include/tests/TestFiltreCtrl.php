<?php

/**
 * Description of TestTypeNum
 * @package Test_Unitaire
 * @author Stef 
 */
require_once ("../class.TypeNum.inc.php");
class TestFilteCtrl extends PHPUnit_Framework_TestCase {
    
    public function testEstEntierPositif(){
        
        $this->assertEquals(1,FiltreCtrl::estEntierPositif(1));
        $this->assertEquals(null,FiltreCtrl::estEntierPositif(1.2));
        $this->assertEquals(null,FiltreCtrl::estEntierPositif("foo"));
        
        $arr = [1,2,3];
        $this->assertEquals(true ,FiltreCtrl::estTableauEntiers($arr));
        
         $arr = [1,"foo",3];
        $this->assertEquals(false ,FiltreCtrl::estTableauEntiers($arr));
    }
}
