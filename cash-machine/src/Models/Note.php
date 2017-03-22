<?php
/**
 * Created by PhpStorm.
 * User: cisco
 * Date: 22/03/17
 * Time: 16:03
 */
namespace CM\Models;

class Note
{
    /**
     * @var float
     */
    private $value;

    /**
     * Note constructor.
     * @param float $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }
}
