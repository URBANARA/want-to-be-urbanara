<?php

Class CashMachine
{
    private $notes = array();

    public function __construct()
    {
        $this->notes = array(100, 50, 20, 10);
    }

    private function getNote($amount)
    {
        $lowest_note_count = null;
        $lowest_note       = null;
        //loop through the notes
        foreach ($this->notes as $note)
        {
            //get the maximum amount of notes
            $notes_count = floor($amount / $note);
            //check if thats the lowest found
            $lowest_note_count = $lowest_note_count === null ? ($notes_count > 0 ? $notes_count : null) : ($notes_count > 0 ? min($lowest_note_count, $notes_count) : null);
            //if so add it to the notes list
            $lowest_note = $lowest_note_count === $notes_count ? $note : $lowest_note;
        }
        return $lowest_note_count === null ? null : array('lowest_note' => $lowest_note, 'lowest_note_count' => $lowest_note_count);
    }

    private function printer($notes)
    {
        //printer
        foreach ($notes as $note)
        {
            echo $note['lowest_note'] . "*" . $note['lowest_note_count'] . "\n";
        }
        echo "---------------\n";
    }

    public function getNotes($entry)
    {
        $notes       = array();
        $left_amount = $entry;
        //loop until there are no notes for the left amount or there are no more left amount
        while ($left_amount > 0 && null !== ($note = $this->getNote($left_amount)))
        {
            //calculate the amount from the notes
            $amount = ($note['lowest_note'] * $note['lowest_note_count']);
            //get the balance
            $left_amount = $left_amount - $amount;
            //push the notes to an array
            $notes[] = $note;
        }
        //exception
        if ($left_amount > 0)
        {
            throw new NoteUnavailableException();
        }

//        //printer for cli use
//        $this->printer($notes);
        //return as an array
        $individual_notes = array();
        foreach ($notes as $note)
        {
            for ($x = 0; $x < $note['lowest_note_count']; $x++)
            {
                $individual_notes[] = $note['lowest_note'];
            }
        }
        return $individual_notes;
    }
}

class NoteUnavailableException extends Exception
{

}

$CashMachine = new CashMachine();

var_dump($CashMachine->getNotes(30));
var_dump($CashMachine->getNotes(50));
var_dump($CashMachine->getNotes(80));
var_dump($CashMachine->getNotes(90));
var_dump($CashMachine->getNotes(130));
var_dump($CashMachine->getNotes(null));
var_dump($CashMachine->getNotes(125));