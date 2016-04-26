<?php

namespace Urbanara\CashMachine;

class CashMachine 
{
	
	protected $notes = [100, 50, 20, 10];
	protected $input;
	
	public function setInput($input) 
	{
		$this->checkValidInput($input);
		$this->input = $input;
		return $this;
	}
	
	public function getInput()
	{
		if (empty($this->input))
			return 'Empty Set';
		return $this->input;
	}
	
	private function checkValidInput($input)
	{
		if (empty($input))
			return;
		if (!is_numeric($input))
			throw new \InvalidArgumentException;
		if ($input < 0)
			throw new \InvalidArgumentException;
				
		if ($input % 2 !== 0)
			throw new NoteUnavailableException;
	}
	
	public function execute()
	{
		$input = $this->getInput();
		if (is_string($input))
			return $input;
		if (in_array($input, $this->notes))
			return [$this->format($input)];
		
		return $this->calculatorNotes($input);
	}
	
	private function format($input) 
	{
		return number_format($input, 2);
	}
	
	private function calculatorNotes($input)
	{		
		$returnNotes = [];

		while($input > 0) {
			$index = 0;
			$countNotes = count($this->notes);
			while ($index < $countNotes) {
				$note = $this->notes[$index];
				$amount = $input - $note;
				if ($amount < 0) {
					$index++;
					continue;
				}

				if ($amount >= 0) {
					$returnNotes[] = $note;
					$input -= $note;
				} 
			}
		}
				
		return $returnNotes;
	}
}

