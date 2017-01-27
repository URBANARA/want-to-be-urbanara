<?php namespace App\Libraries;

use AppExceptions\NoteUnavailableException;

class CashMachine
{
    protected $notes = [100,50,20,10];
    protected $amount;
    protected $balance;
    protected $withdrawNotes = [];

    public function setAmount( int $amount = null )
    {
        if( $this->validateAmount( $amount ) ){
            if( $amount == null ){
                $amount = 0;
            }
            $this->amount = $amount;
        }
    }
    public function withdraw ( int $amount = null ) : array
    {
        $this->setAmount( $amount );
        if( $this->checkAvailability() ){
            $this->setBalance( $this->amount );
            foreach ( $this->notes as $note ){
                $this->addNotesInWithdraw( $note );
            }
            return $this->withdrawNotes;
        }

    }

    protected function setBalance ( int $amount )
    {
        $this->balance = $amount;
    }
    protected function addNotesInWithdraw( float $note )
    {
        if( $this->balance >= $note ){
            $validNoteAmount = floor( $this->balance / $note );
            for( $i=0 ; $i < $validNoteAmount ; $i++ ){
                array_push( $this->withdrawNotes , round( $note , 2 ) );
            }
            $this->setBalance( $this->balance % $note );
        }
    }
    protected function validateAmount( int $amount = null ) : bool
    {
        if( $amount < 0 && $amount != null ){
            throw new \InvalidArgumentException( "Amount should be greated that 0" );
        }
        return true;
    }
    protected function checkAvailability() : bool
    {
        $smallestNote = end( $this->notes );
        if( $this->amount % $smallestNote != 0 ){
            throw new NoteUnavailableException( "Notes not available" );
        }
        return true;
    }
}
