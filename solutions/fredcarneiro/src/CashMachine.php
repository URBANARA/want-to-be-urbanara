<?php

Namespace Carneiro\CashMachine;

class CashMachine
{

	const AVAIABLE_NOTES = [100, 50, 20, 10];

	private $notes = [];
	private $restAmount = 0;


	public static function notes(?int $amount) : array
	{
		if(is_null($amount)) return [];

		$cashMachine = new self;

		$cashMachine->restAmount = $amount;

		$cashMachine->getNotes($amount);
		
		return $cashMachine->notes; 

	}

	private function getNotes(int $amount) : void
	{
			
		$this->checkDivisionByMinimumNote($amount);
		$this->checkNegativeAmount($amount);

		while ($this->restAmount > 0) {
			
			array_filter(self::AVAIABLE_NOTES, function($note) use ($amount) {

				if($note <= $this->restAmount) {

					$quantityOfNotes = floor($this->restAmount / $note);

					if ($quantityOfNotes === 0) $quantityOfNotes = 1;

					$diff = $this->restAmount - ($note * $quantityOfNotes);

					if($diff >= 0) {

						$this->restAmount -= $note * $quantityOfNotes;

						for ($i=0; $i < $quantityOfNotes; $i++) { 
							$this->notes[] = $note;
						}

						return;						
					}

				}

			});

		} 

	}

	private function checkDivisionByMinimumNote(int $amount) 
	{
		if ($amount % min(self::AVAIABLE_NOTES) != 0) throw new NoteUnavailableException;
	}

	private function checkNegativeAmount(int $amount) 
	{
		if ($amount < 0) throw new InvalidArgumentException;
	}

}