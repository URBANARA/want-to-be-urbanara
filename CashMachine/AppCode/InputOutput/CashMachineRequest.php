<?php
/**
 * Created by PhpStorm.
 * User: Amirali
 * Date: 6/13/2016
 * Time: 11:40 AM
 */

namespace AppCode\InputOutput;


class CashMachineRequest
{
    private $amount;

    public function __construct($amount = NULL)
    {
        if ($this->amount === NULL)
            $this->amount = 0;

        $this->amount = $amount;
    }

    public function GetAmount()
    {
        return $this->amount;
    }
}