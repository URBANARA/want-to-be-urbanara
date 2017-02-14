<?php
    /**
     * The very beginning of the CashMachine challenge.
     *
     * Created by PhpStorm.
     *
     * @package CashMachine
     * @author gustavopereira
     * @since  11/02/17 - 22:13
     */

    namespace CashMachine;

    use Exception\InvalidArgumentException;
    use Exception\NoteUnavailableException;

    class Atm implements CashMachineInterface
    {

        /**
         * @var array all available bills for this ATM
         * @access ${private}
         */
        private $bills = [];

        /**
         * Atm constructor.
         * @access public
         */
        public function __construct($bills)
        {
            //In this particular case, we will fill ATM with money as soon as it arrives.
            $this->loadWithMoney($bills);
        }

        /**
         * Load the ATM with money.
         * @param $bills array with bills (e.g [50,30,10])
         * @access
         */
        public function loadWithMoney($bills)
        {
            $this->bills = $bills;
        }


        /**
         * Withdraw money from ATM and do all the math
         * @param $amount
         * @access
         * @return array|NoteUnavailableException|InvalidArgumentException
         */
        public function withdrawMoney($amount) {
            try
            {
                if($amount==0) {
                    return null;
                }
                if ($amount < 0 ) {
                    throw new InvalidArgumentException();
                }
                if (!$this->checkValidAmount($amount)) {
                    throw new NoteUnavailableException();
                }
                $noteCount = 0;
                $result = [];
                foreach ($this->bills as $bill) {
                    while ($amount >= $bill ) {
                        $noteCount++;
                        $result[] = $bill;
                        $amount=$amount-$bill;
                    }
                }
                return $result;
            }
            catch (NoteUnavailableException $nEx) {
                return $nEx;
            }
            catch(InvalidArgumentException $invalidEx) {
                return $invalidEx;
            }
        }


        /**
         * Get the sum of all available bills loaded in ATM
         * @access private
         * @return number
         */
        private function getSumOfAllAvailableBills() {
            return array_sum($this->bills);
        }

        /**
        * check if the given amount is a valid number
        * the ATM can deliver
         * @access private
         * @return bool
        **/
        private function checkValidAmount($amount)
        {
            //we do some mod divisions to ensure that ATM will have all available notes
            foreach ($this->bills as $note) {
                $remaining = ($amount>$note)?$amount%$note:$note%$amount;
                if ($remaining < $note) {
                    continue;
                }
            }
            //If some value remains, it means that ATM hasnt all bucks we need
            return ($remaining==0);
        }
    }
