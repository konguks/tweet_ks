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
        $this->assertEquals(5,Add(3,2));
    }
    public function Subtest(){
        $this->assertEquals(1,Sub(3,2));
    }
}