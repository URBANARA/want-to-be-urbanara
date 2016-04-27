<?php

namespace ATM;

/**
 * Class ATM
 * @package ATM
 */
class ATM
{
	private $availableNotes;

	public function __construct()
	{
		$this->availableNotes = [100, 50, 20, 10];
	}

	/**
	 * @param null $amount
	 * @return mixed
	 * @throws NoteUnavailableException
	 * @throws \Exception
	 */
	public function withdraw($amount = null)
	{
		if ($this->validateAmount($amount)) {
			return $this->buildCashBackQueue($amount);
		}
	}

	/**
	 * @param $amount
	 * @return bool
	 * @throws NoteUnavailableException
	 * @throws \Exception
	 */
	private function validateAmount($amount)
	{
		if ($amount === null) {
			throw new \Exception("Empty amount not allowed", 3);
		}

		if ($amount <= 0) {
			throw new \InvalidArgumentException("Negative amount ? hm ...", 2);
		}

		if ($amount % 10 != 0) {
			throw new NoteUnavailableException("Not supported amount", 1);
		}

		return true;
	}

	/**
	 * @param int $amount
	 * @return array
	 */
	private function buildCashBackQueue($amount)
	{
		$result = [];

		while ($amount > 0) {
			foreach($this->availableNotes as $note) {
				if (($amount - $note) >= 0) {
					$amount -= $note;
					array_push($result, $note);
					continue 1;
				}
			}
		}

		return $result;
	}
}