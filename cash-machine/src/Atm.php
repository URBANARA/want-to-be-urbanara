<?php
    use Exception\NoteUnavailableException;

    class Atm
    {
        private $availableNotes = [100.00, 50.00, 20.00, 10.00];
        private $min;

        public function __construct()
        {
            arsort($this->availableNotes);
            $this->min = min($this->availableNotes);
        }

        public function withdraw($amount = null)
        {
            if(!$amount)
                return [];

            if($amount < 0 || !is_numeric($amount))
                throw new \InvalidArgumentException('The requested amount must be a positive number.');

            if(fmod($amount, $this->min) > 0)
                throw new NoteUnavailableException('There are no notes available for the requested amount.');

            $result = [];
            foreach($this->availableNotes as $note) {
                $thisNoteQty = floor($amount / $note);
                if($thisNoteQty > 0) {
                    $notes = array_fill(0, $thisNoteQty, $note);
                    $result = array_merge($result, $notes);
                    $amount -= $note * $thisNoteQty;
                }
                if($amount == 0) break;
            }

            return $result;
        }
    }