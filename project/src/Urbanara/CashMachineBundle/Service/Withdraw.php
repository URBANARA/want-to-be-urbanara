<?php
namespace Urbanara\CashMachineBundle\Service;

Class Withdraw {
	public function checkNotes($amount) {
		if ($amount <= 0) throw new \InvalidArgumentException;
		foreach (self::getAvailableNotes() as $bill) {
			if ($amount >= $bill) {
				/*
				We just need to divide it, top to bottom, with all available notes
				Quotient: the number of notes of that amount
				Remainder: run it recursivelly
				*/
				$remainder = $amount % $bill;
				$return_bills = [];
				for ($i = 1; $i <= $amount / $bill; $i++) {
					$return_bills[] = $bill;
				}
				return !$remainder ? $return_bills : array_merge($return_bills, $this->checkNotes($remainder)); 
			}
		}
		throw new \Urbanara\CashMachineBundle\Exception\NoteUnavailableException;
	}

	// This is just a mock of how the real withdraw function should work
	public function withdraw($amount, $customer) {
		/*
		$customer->checkBalance($amount);
		$withdraw = $this->checkNotes($amount);
		$customer->withdrawBalance($amount);
		return $withdraw;
		*/
	}

	private function getAvailableNotes() {
		return [100, 50, 20, 10];
	}
}
