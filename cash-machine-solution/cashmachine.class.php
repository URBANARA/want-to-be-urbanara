<?php

/**
 * Cash machine
 */
class CashMachine {
	// order must be maximum to minimum
	private $available_notes = array(100, 50, 20, 10);

	/**
	 * find notes with given amount
	 * @param  integer $amount
	 * @return array
	 */
	public function notes($amount) {
		if (empty($amount))
			return array();

		if (is_numeric($amount) === false || is_float($amount) || $amount < 0)
			throw new Exception('InvalidArgumentException');

		foreach ($this->available_notes as $value)
			if ($value <= $amount) {
				$notes[] = $value;

				$remain = $amount - $value;

				if ($remain > 0)
					$notes = array_merge($notes, $this->notes($remain));
				
				return $notes;
			}

		throw new Exception('NoteUnavailableException');
	}
}

?>