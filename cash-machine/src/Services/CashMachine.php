<?php
/**
 * Created by PhpStorm.
 * User: cisco
 * Date: 22/03/17
 * Time: 16:01
 */
namespace CM\Services;

use CM\Exceptions\NoteUnavailableException;
use CM\Models\Money;
use CM\Models\Note;
use CM\Models\Withdraw;

class CashMachine
{
    const VALID_NOTES = [100, 50, 20, 10];

    /**
     * @param Money $amount
     */
    public function withdraw(Money $amount)
    {
        $withdraw = new Withdraw($amount);
        foreach (self::VALID_NOTES as $noteValue) {
            $notesNumber = $withdraw->getNumberOfNotesOfValueNeeded($noteValue);
            if ($notesNumber < 1) {
                continue;
            }
            for ($i = 0; $i < $notesNumber; $i++) {
                $withdraw->addNote(new Note($noteValue));
            }
            if ($withdraw->isFilled()) {
                return $withdraw;
            }
        }
        throw new NoteUnavailableException();
    }
}
