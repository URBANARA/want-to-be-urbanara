<?php

namespace Kix\Urbanara\CashWithdrawal;

/**
 * Class DenominationCollection
 */
class DenominationCollection implements \Iterator
{
    private $items;

    private $cursor = 0;
    
    public function __construct(array $denominations)
    {
        if (!count($denominations)) {
            throw new \InvalidArgumentException('At least one denomination is required');
        }

        array_map(function ($denomination) {
            if (!is_numeric($denomination)) {
                throw new \InvalidArgumentException(sprintf(
                    '%s is not a valid denomination',
                    $denomination
                ));
            }

            return (float) $denomination;
        }, $denominations);

        sort($denominations);
        $this->items = array_reverse($denominations);
    }

    public function min()
    {
        return min($this->items);
    }

    public function current()
    {
        return $this->items[$this->cursor];
    }

    public function next()
    {
        $this->cursor++;
    }

    public function key()
    {
        return $this->cursor;
    }

    public function valid()
    {
        return array_key_exists($this->cursor, $this->items);
    }

    public function rewind()
    {
        $this->cursor = 0;
    }
}
