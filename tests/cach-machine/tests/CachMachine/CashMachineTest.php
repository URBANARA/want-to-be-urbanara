<?php

namespace Urbanara\CashMachine;

use PHPUnit_Framework_TestCase;

class CashMachineTest extends PHPUnit_Framework_TestCase
{
	
	/**
	 *
	 * @var \Urbanara\CashMachine\CashMachine
	 */
	protected $cashMachine;
	
	public function setUp() 
	{
		$this->cashMachine = new CashMachine();
	}
	
	/**
     * @expectedException \InvalidArgumentException
     */
	public function testSholdBeInputInvalidString()
	{
		$input = 'something';
		$this->cashMachine->setInput($input);
	}
	
	/**
     * @expectedException \InvalidArgumentException
     */
	public function testSholdBeInputInvalidLessZero()
	{
		$input = -1;
		$this->cashMachine->setInput($input);
	}
	
	/**
     * @expectedException \Urbanara\CashMachine\NoteUnavailableException
     */
	public function testShouldBeInputInvalidNote()
	{
		$input = 125;
		$this->cashMachine->setInput($input);
	}
		
	public function testShouldBeInputEmpty()
	{		
		$this->cashMachine->setInput(null);
		$this->assertEquals('Empty Set', $this->cashMachine->getInput());
	}
	
	public function testShouldBeInputValid()
	{
		$input = 120;
		$cashMachine = $this->cashMachine->setInput($input);
		$this->assertTrue($cashMachine instanceof \Urbanara\CashMachine\CashMachine);
	}
	
	public function testShouldBeOneNote()
	{
		$input = 10;
		$notes = $this->cashMachine->setInput($input)
							->execute();
		$expected = array(10.00);
		$this->assertEquals($expected, $notes);
	}
	
	public function testShouldBeLessNote30()
	{
		$input = 30;
		$notes = $this->cashMachine->setInput($input)
							->execute();
		$expected = array(20.00, 10.00);
		$this->assertEquals($expected, $notes);
	}
	
	public function testShouldBeLessNote80()
	{
		$input = 80;
		$notes = $this->cashMachine->setInput($input)
							->execute();
		$expected = array(50.00, 20.00, 10.00);
		$this->assertEquals($expected, $notes);
	}
	
	public function testShouldBeReturnEmpty()
	{
		$input = 0;
		$notes = $this->cashMachine->setInput($input)
							->execute();		
		$this->assertEquals('Empty Set', $notes);
	}
	
}
