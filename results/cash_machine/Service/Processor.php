<?php
/**
 * User: Oleksii Polishchuk
 * Date: 21.05.2016
 */

namespace CashMachine\Service;

/**
 * Class Processor - main service to perform the calculation
 *
 * @package CashMachine\Service
 */
class Processor
{
    /**
     * @var Validator
     */
    protected $validator;

    /**
     * @var array
     */
    protected $nominals;

    /**
     * @var Calculator
     */
    protected $calculator;

    /**
     * Processor constructor.
     */
    public function __construct()
    {
        $this->setValidator(new Validator());
        
        $this->setNominals(array(
            100, 50, 20, 10
        ));
    }

    /**
     * Return array of nominals needed to withdraw required amount
     * @param $amount
     * @return array
     * @throws \CashMachine\Exception\NoteUnavailableException
     */
    public function withdraw($amount)
    {   
        $this->getValidator()->validate($amount, $this->getNominals());

        $calculator = new Calculator($amount, $this->getNominals());
        return $calculator->calculate();
    }

    /**
     * @return Validator
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param Validator $validator
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
    }

    /**
     * @return array
     */
    public function getNominals()
    {
        return $this->nominals;
    }

    /**
     * @param array $nominals
     */
    protected function setNominals($nominals)
    {
        $this->nominals = $nominals;
    }

}