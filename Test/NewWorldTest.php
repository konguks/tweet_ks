<?php
/**
 * Created by PhpStorm.
 * User: kongu
 * Date: 02-Aug-15
 * Time: 1:02 PM
 */
class NewWorldTest extends PHPUnit_Framework_TestCase
{
    public function Addtest(){
        $nw = new NewWorld();
        $this->assertEquals(5,$nw->Add(3,2));
    }
    public function Subtest(){
        $nw = new NewWorld();
        $this->assertEquals(1,$nw->Sub(3,2));
    }
}