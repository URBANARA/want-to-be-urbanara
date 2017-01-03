<?php

namespace CashMachine;

use \CashMachine\Exceptions\InvalidNoteSetException;
use \CashMachine\Exceptions\NoteUnavailableException;

/**
* NoteSet represents a dataset of notes and their quantities. It implements Countable
* and ArrayAccess standard interfaces for allowing the set to be counted and used as
* an array object.
*
* @package CashMachine
* @author  Walter Carrer Neto <carrer@gmail.com>
* @version 1.0
* @access  public
*/
final class NoteSet implements \Countable, \ArrayAccess
{

    /**
   * @var array   $notes Notes which compose this set and their quantities.
   */
    protected $notes = array();

    /**
    * @access public
    * @param  array $notes Provides a initial set of notes. The array elements must follow 
    * the format: NOTE => QUANTITY ; Example: [ 1 => 2 , 5 => 10, 10 => 50 ], Meaning 2 notes
    * of 1, 10 of 5 and 50 of 10. 
    * @throws InvalidNoteSetException When $notes fails to follow the format
    * required.
    */
    public function __construct(array $notes)
    {
        ksort($notes);
        foreach ($notes as $note => $quantity) {
            if (!is_int($note) || $note <= 0 || !is_int($quantity) || $quantity <= 0) {
                throw new InvalidNoteSetException();
            }

            $obj = new \stdClass();
            $obj->note = $note;
            $obj->quantity = $quantity;
            $this->notes[] = $obj;
        }
    }

    /**
    * Subtracts an amount of notes from a set.
    * @access public
    * @param  array $notes Informs which notes and their quantities that should be 
    * substracted from the current set. that should be substracted from the current set.
    * that should be substracted from the current set.
    * @throws NoteUnavailableException When there are notes in $notes which
    * doesn't exists in the current set.
    */
    public function Subtract(NoteSet $notes)
    {
        for ($i=0;$i<sizeof($notes);$i++) {
            $obj = $notes[$i];
            $sizeOfNotes = sizeof($this->notes);
            for ($j=0;$j< $sizeOfNotes;$j++) {
                if ($this->notes[$j]->note == $obj->note) {
                    $this->notes[$j]->quantity -= $obj->quantity;
                    break;
                } elseif ($j == $sizeOfNotes-1) {
                    throw new NoteUnavailableException();
                }
            }
        }
    }

    /**
    * Overwriting toString method for providing a pretty debug-format
    * @access public
    * @return string Pretty string with all notes and their quantities in the set
    */
    public function __toString() : string
    {
        $n = sizeof($this->notes);
        $output = str_pad(' ', $n*12, '-')."--\n";
        for ($i=0;$i<$n;$i++) {
            $output .= " | $       #";
        }
        $output .= " |\n ";
        foreach ($this->notes as $obj) {
            $output .= '| '.str_pad($obj->note, 4, ' ', STR_PAD_RIGHT).str_pad($obj->quantity, 5, ' ', STR_PAD_LEFT)." ";
        }
        $output .= "|\n";
        // return print_r($this->notes, true);
        $output .= str_pad(' ', $n*12, '-')."--\n";
        return $output;
    }

    /**
    * "Casts" the set into an array format (where the note-labels are indexes
    * and quantities are values.
    * @access public
    * @return array
    */
    public function toArray() : array
    {
        $output=array();
        foreach ($this->notes as $obj) {
            $output[$obj->note] = $obj->quantity;
        }
        return $output;
    }

    /**
    * Counts how many elements are in the set.
    * @access public
    * @return int   Number of elemets in the set.
    */
    public function count() : int
    {
        return sizeof($this->notes);
    }

    public function offsetSet($offset, $value)
    {
        if (!is_null($offset)) {
            $this->notes[$offset]->quantity = $value;
        }
    }

    public function offsetExists($offset) : bool
    {
        return isset($this->notes[$offset]);
    }

    public function offsetUnset($offset)
    {
        // should not remove element
    }

    public function offsetGet($offset)
    {
        return isset($this->notes[$offset]) ? $this->notes[$offset] : null;
    }
}
