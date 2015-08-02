<?php


class HelloWorldTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PDO
     */
    private $pdo;

    public function setUp()
    {
        $this->assertEquals(5,5);
    }

    public function tearDown()
    {
        $this->assertEquals(5,5);
    }

    public function testHelloWorld()
    {
        $this->assertEquals(5,5);
    }

    public function testHello()
    {
        $this->assertNotEquals('Karthick','Bhuvana');
    }

    public function testWhat()
    {

        $this->assertFalse(False);

        $this->assertNotEquals('Karthick','Bhuvana');
    }

}

