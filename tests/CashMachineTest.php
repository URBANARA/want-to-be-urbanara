<?php

use PHPUnit\Framework\TestCase;

class CashMachineTest extends TestCase
{
    protected $obj;

    public  function setUp()
    {
        $this->obj = new App\Libraries\CashMachine();
    }
    public function tearDown()
    {
        $this->obj = null;
    }

    public function testNullSet()
    {
        $this->assertEquals( [] , $this->obj->withdraw() );
    }

    public function testZeroWithdrawl()
    {
        $this->assertEquals( [] , $this->obj->withdraw(0) );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgumentException()
    {
        $this->obj->withdraw( -135.00 );
    }

    /**
     * @expectedException AppExceptions\NoteUnavailableException
     */
    public function testNoteUnavailableException()
    {
        $this->obj->withdraw( 125.00 );
    }

    public function testWithdaw30()
    {
        $this->assertEquals( [20.00,10.00] , $this->obj->withdraw(30) );
    }

    public function testWithdaw80()
    {
        $this->assertEquals( [50.00,20.00,10.00] , $this->obj->withdraw(80) );
    }

    public function testWithdaw100()
    {
        $this->assertEquals( [100.00] , $this->obj->withdraw(100) );
    }

    public function testWithdaw380()
    {
        $this->assertEquals( [100.00,100.00,100.00,50.00,20.00,10.00] , $this->obj->withdraw(380) );
    }
}