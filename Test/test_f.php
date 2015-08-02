<?php

class test_f extends PHPUnit_Framework_TestCase
{
	public function test_1(){
		#$tst = new try_1();
		$this->assertEquals(5,5);
	}
	public function test_2(){
		$this->assertNotEquals('Karthick','Bhuvana');
	}
}