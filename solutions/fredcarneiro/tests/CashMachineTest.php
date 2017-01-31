<?php

Namespace Carneiro\CashMachine;

use PHPUnit\Framework\TestCase;


/**
 * @package Carneiro\CashMachine
 */

class CashMachineTest extends Testcase 
{

	/**
	 * @covers ::notes
	 */
	public function testWithEntryOf30()
	{

		$amount = 30;

		$notes = CashMachine::notes($amount);

		$expectedNotes = [20, 10];

		$this->assertInternalType('array', $notes);
		$this->assertEquals($notes, $expectedNotes);
	}

	/**
	 * @covers ::notes
	 */
	public function testWithEntryOf80()
	{

		$amount = 80;

		$notes = CashMachine::notes($amount);

		$expectedNotes = [50, 20, 10];

		$this->assertInternalType('array', $notes);
		$this->assertEquals($notes, $expectedNotes);
	}

	/**
	 * @covers ::notes
	 */
	public function testWithEntryOf380()
	{

		$amount = 380;

		$notes = CashMachine::notes($amount);

		$expectedNotes = [100, 100, 100, 50, 20, 10];

		$this->assertInternalType('array', $notes);
		$this->assertEquals($notes, $expectedNotes);
	}

	/**
	 * @covers ::notes
	 */
	public function testWithInvalidNote()
	{

		$amount = 125;

		$this->expectException(NoteUnavailableException::class);
		
		CashMachine::notes($amount);

	}

	/**
	 * @covers ::notes
	 */
	public function testWithNegativeNumber()
	{

		$amount = -130;

		$this->expectException(InvalidArgumentException::class);
		
		CashMachine::notes($amount);

	}


	/**
	 * @covers ::notes
	 */
	public function testWithNullEntry()
	{

		$amount = null;

		$notes = CashMachine::notes($amount);

		$expectedNotes = [];

		$this->assertInternalType('array', $notes);
		$this->assertEquals($notes, $expectedNotes);

	}

}