<?php
/**
 * User: Oleksii Polishchuk
 * Date: 21.05.2016
 */

namespace CashMachine\Service;


/**
 * Class Validator checks initial parameters for withdrawal calculation
 * 
 * @package CashMachine\Service
 */
class Validator
{
    public function validate($amount, array $nominals)
    {
        // validate input params
        if (empty($amount) || !is_integer($amount) || $amount < 0) {
            throw new \InvalidArgumentException('The amount is empty or invalid.');
        }

        // check nominals
        foreach ($nominals as $value) {
            if (empty($value) || !is_integer($value)) {
                throw new \InvalidArgumentException("The nominals set cannot be empty and should contain only positive integers");
            }
        }
    }

}