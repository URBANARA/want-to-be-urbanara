<?php

/**
 * Class CashMachine
 */
class CashMachine {

    private $notes = [10.00, 20.00, 50.00, 100.00];

    /**
     * Prepare the withdraw, validate and calculate the notes needed
     *
     * @param $sum
     * @return array|bool
     */
    public function redraw($sum) {
        if ($sum == null) {
            return ['Empty Set'];
        }

        $sum = $this->string2Float($sum);

        try {
            $this->validate($sum);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $notes = [];
        $notes = $this->getNotes($sum, $notes);

        return $notes;
    }

    /**
     * Validate the sum
     *
     * @param $sum
     * @return bool
     * @throws Exception
     */
    private function validate($sum) {
        if ($sum <= 0) {
            throw new Exception('InvalidArgumentException');
        }

        foreach ($this->notes as $note) {
            if (fmod($sum, $note) == 0) {
                return true;
            } else {
                throw new Exception('NoteUnavailableException');
            }
        }
    }

    /**
     * A recursive function to calculate the notes needed
     *
     * @param $sum
     * @param $notes
     * @return array
     */
    private function getNotes($sum, &$notes) {
        $noOfNotes = count($this->notes);
        for ($i = $noOfNotes - 1; $i >= 0; $i--) {
            if ($sum >= $this->notes[$i]) {
                $notes[] = $this->notes[$i];
                $this->getNotes(($sum - $this->notes[$i]), $notes);
                break;
            }
        }

        return $notes;
    }

    /**
     * Convert a string to float
     *
     * @param $value
     * @return float
     */
    private function string2Float($value) {
        //find last delimiter
        $lastComma = (int)strrpos($value, ',');
        $lastDot = (int)strrpos($value, '.');

        if ($lastComma > $lastDot) {
            $value = str_replace(".", "", $value);
            $value = str_replace(",", ".", $value);
        } elseif ($lastComma < $lastDot) {
            $value = str_replace(",", "", $value);
        }

        return (float)$value;
    }
}