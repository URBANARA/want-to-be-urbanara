<?php
declare(strict_types=1);

namespace CashMachine\Withdraw;

use CashMachine\Withdraw\NoteUnavailableException;
use InvalidArgumentException;

class WithdrawService
{
    public function calculateDelivery(float $value = null, array $notesAvailable = []): array
    {

        if ($value < 0) {
            throw new InvalidArgumentException('Value must be greater than 0');
        }
        sort($notesAvailable);
        $greatOrder = array_reverse($notesAvailable);

        $remainder = $value;
        $result = [];

        foreach ($greatOrder as $note) {
            if ($remainder < $note) {
                continue;
            }
            $result[$note] = 0;
            while ($remainder >= $note) {
                $result[$note]++;
                $remainder -= $note;
            }
        }
        if ((int) $remainder !== 0) {
            throw new NoteUnavailableException((int) $remainder, 'Note unavailable: ' . $remainder);
        }
        return $result;
    }
}
