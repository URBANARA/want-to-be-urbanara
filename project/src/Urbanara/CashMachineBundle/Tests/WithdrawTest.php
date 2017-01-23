<?php
namespace Urbanara\CashMachineBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WithdrawTest extends WebTestCase
{
	public function testOk()
	{
		$client = static::createClient();
		$cashmachine = $client->getContainer()->get('cashmachine');

		// Single notes
		$this->assertEquals([100], $cashmachine->checkNotes(100));
		$this->assertEquals([50], $cashmachine->checkNotes(50));
		$this->assertEquals([20], $cashmachine->checkNotes(20));
		$this->assertEquals([10], $cashmachine->checkNotes(10));

		// All notes
		$this->assertEquals([100, 50, 20, 10], $cashmachine->checkNotes(180));

		// More of the same note
		$this->assertEquals([100, 100, 20, 20], $cashmachine->checkNotes(240));
	}

	public function testInvalid() {
		$client = static::createClient();
		$cashmachine = $client->getContainer()->get('cashmachine');

		$this->setExpectedException(\InvalidArgumentException::class);

		$cashmachine->checkNotes(-100);
	}

	public function testUnavailable() {
		$client = static::createClient();
		$cashmachine = $client->getContainer()->get('cashmachine');

		$this->setExpectedException(\Urbanara\CashMachineBundle\Exception\NoteUnavailableException::class);

		$cashmachine->checkNotes(105);
	}
}