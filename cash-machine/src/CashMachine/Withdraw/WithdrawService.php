<?php
declare(strict_types=1);

namespace CashMachine\Withdraw;

use CashMachine\Withdraw\NoteUnavailableException;
use InvalidArgumentException;

class WithdrawService
{
    public function calculateDeliver(float $value, array $notesAvailable): array
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('Value must be greather then 0');
        }
        sort($notesAvailable);
        $greateOrder = array_reverse($notesAvailable);

        $remainder = $value;
        $result = [];

        foreach ($greateOrder as $note) {
            $result[$note] = 0;
            if ($remainder < $note) {
                continue;
            }
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
