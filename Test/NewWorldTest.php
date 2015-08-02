<?php
/**
 * Created by PhpStorm.
 * User: kongu
 * Date: 02-Aug-15
 * Time: 1:02 PM
 */
class NewWorldTest extends PHPUnit_Framework_TestCase
{
    public function testAdd()
    {
        $nw = new NewWorld();
        $this->assertEquals(5,$nw->Add(3,2));
    }
    public function testSub()
    {
        $nw = new NewWorld();
        $this->assertEquals(1,$nw->Sub(3,2));
    }
    public function testAPICon(){
        $nw = new NewWorld();
        $this->assertNotEquals(NULL,$nw->GetAPICon());
    }
    public function testSearchTweet(){
        $nw = new NewWorld();
        $toa = $nw->GetAPICon();
        $str = '#Verizon';

        $query = array(
            "q" => rawurlencode($str),
            "count" => 1000,
            "result_type" => "recent"
        );

        $this->assertNotEquals(NULL,$nw->GetSearchTweet($toa,$query));
    }

    public function testNoErrorsrch(){
        $nw = new NewWorld();
        $toa = $nw->GetAPICon();
        $str = '#Verizon';

        $query = array(
            "q" => rawurlencode($str),
            "count" => 100,
            "result_type" => "recent"
        );

        $this->assertArrayNotHasKey('error',(array)$nw->GetSearchTweet($toa,$query));
    }
    public function testTrendPlace(){
        $nw = new NewWorld();
        $toa = $nw->GetAPICon();

        $query = array(
            "id" => 1
        );

        $this->assertNotEquals(NULL,$nw->GetTrendPlace($toa,$query));
    }
    public function testNoErrortrnd(){
        $nw = new NewWorld();
        $toa = $nw->GetAPICon();

        $query = array(
            "id" => 1
        );

        $this->assertArrayNotHasKey('error',$nw->GetTrendPlace($toa,$query));
    }

}