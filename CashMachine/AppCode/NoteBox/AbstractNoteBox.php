<?php

/**
 * Created by PhpStorm.
 * User: amiralijiwani
 * Date: 12/06/2016
 * Time: 11:44 PM
 */

namespace AppCode\NoteBox;

use AppCode\InputOutput\CashMachineResponse;

abstract class AbstractNoteBox implements INoteBox
{
    protected $nextNoteBox;

    public function __construct()
    {
        $this->nextNoteBox = NULL;
    }

    abstract public function GetNote();

    public function ConsumeNotes($numNotes)
    {
        if ($this->HasNotesAvailable($numNotes))
        {
            // Some consume logic here, if applicable (which in our case is not)
            return true;
        }

        return false;
    }

    public function HasNotesAvailable($numNotes)
    {
        // As we have unlimited notes, we can simply state that we always have x amount of notes
        return true;
    }

    public function HandleRequest(CashMachineResponse &$response)
    {
        if ($response->isAmountConsumed())
            return;

        // Calculate the amount of notes to be consumed
        // $cloneAmount = $response->GetAmount();
        // $noteValue = $this->GetNote()->GetNoteValue();

        while ($response->GetAmount() >= $this->GetNote()->GetNoteValue())
        {
            $response->AddNote($this->GetNote());
        }

        if ($this->nextNoteBox !== NULL)
        {
            $this->nextNoteBox->HandleRequest($response);
        }
    }

    public function SetNextNoteBox(AbstractNoteBox $noteBox)
    {
        $this->nextNoteBox = $noteBox;
    }
}