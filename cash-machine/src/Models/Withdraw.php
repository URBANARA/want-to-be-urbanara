<?php
/**
 * Created by PhpStorm.
 * User: cisco
 * Date: 22/03/17
 * Time: 16:07
 */
namespace CM\Models;

class Withdraw
{
    /**
     * @var Money
     */
    private $amount;

    /**
     * @var Note
     */
    private $notes;

    /**
     * Withdraw constructor.
     * @param Money $amount
     */
    public function __construct(Money $amount)
    {
        /**
         * Its one validation rule, two at max, so no need for a decorator?
         */
        if ($amount->isNegative()) {
            throw new \InvalidArgumentException();
        }
        $this->notes = [];
        $this->amount = $amount;
    }

    /**
     * @param float $noteValue
     * @return int
     */
    public function getNumberOfNotesOfValueNeeded($noteValue)
    {
        return floor($this->amount->subtract($this->getFilledAmount())->divideBy($noteValue));
    }

    /**
     * @param Note $note
     */
    public function addNote(Note $note)
    {
        $this->notes[] = $note;
    }

    /**
     * @return boolean
     */
    public function isFilled()
    {
        return $this->getFilledAmount()->equalTo($this->amount);
    }

    /**
     * @return Money
     */
    private function getFilledAmount()
    {
        $filledAmount = 0;
        foreach ($this->notes as $note) {
            $filledAmount += $note->getValue();
        }
        return new Money($filledAmount);
    }

    /**
     * @return array
     */
    public function asArrayOfNoteValues()
    {
        $notes = [];
        foreach ($this->notes as $note) {
            $notes[] = $note->getValue();
        }
        return $notes;
    }
}
