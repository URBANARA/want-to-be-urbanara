<?php

namespace ATM\Tests;

use ATM\ATM;
use ATM\NoteUnavailableException;

class ATM_Test extends \PHPUnit_Framework_TestCase
{
	public function test_that_ATM_can_not_accept_non_valid_notes()
	{
		$atm = new ATM;

		try {
			$atm->withdraw(123);
			$this->fail("Expected exception not thrown");
		} catch (NoteUnavailableException $e) {
			$this->assertEquals(1, $e->getCode());
		}

		try {
			$atm->withdraw(-130);
			$this->fail("Expected exception not thrown");
		} catch (\InvalidArgumentException $e) {
			$this->assertEquals(2, $e->getCode());
		}

		try {
			$atm->withdraw(NULL);
			$this->fail("Expected exception not thrown");
		} catch (\Exception $e) {
			$this->assertEquals(3, $e->getCode());
		}
	}

	public function test_that_ATM_deliver_notes()
	{
		$atm = new ATM;

		$this->assertEquals([20, 10], $atm->withdraw(30));
		$this->assertEquals([50, 20, 10], $atm->withdraw(80));
	}
}
