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
     * These stuff could also be in another model, like Number preferably
     * but I realized it too late and it's a coding test at the end of the day
     */

    /**
     * @return bool
     */
    public function isNegative()
    {
        return $this->amount < 0;
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
     * @param Money $amount
     * @return int
     */
    public function divideBy(Money $amount)
    {
        return ($this->amount / $amount->amount);
    }

    /**
     * @param Money $amount
     * @return float
     */
    public function subtract(Money $amount)
    {
        return new Money($this->amount - $amount->amount);
    }
}
