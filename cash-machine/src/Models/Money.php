<?php
/**
 * Created by PhpStorm.
 * User: cisco
 * Date: 22/03/17
 * Time: 15:59
 */
namespace CM\Models;

class Money
{
    /**
     * @var Money
     */
    private $amount;

    /**
     * Money constructor.
     * @param float $amount
     */
    public function __construct($amount)
    {
        /**
         * See Withdraw.php:29 :D
         */
        if (!is_float($amount) && !is_integer($amount)) {
            throw new \InvalidArgumentException();
        }
        $this->amount = $amount;
    }

    /**
     * @param Money $amount
     * @return boolean
     */
    public function equalTo(Money $amount)
    {
        return ($amount->amount == $this->amount);
    }

    /**
     * @param float $amount
     * @return int
     */
    public function divideBy($amount)
    {
        return ($this->amount / $amount);
    }

    /**
     * @param Money $amount
     * @return float
     */
    public function subtract(Money $amount)
    {
        return new Money($this->amount - $amount->amount);
    }

    /**
     * @return bool
     */
    public function isNegative()
    {
        return $this->amount < 0;
    }
}
