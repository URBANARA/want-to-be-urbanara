<?php
    /**
     * CashMachineInterface.php
     *
     * A class used to define what does it takes to be a cashmachine
     * in the world of Cash Machines
     * Created by PhpStorm
     * @package CashMachine
     * @author gustavopereira
     * @since  13/02/17 - 22:16
     */

    namespace CashMachine;


    interface CashMachineInterface
    {
        /**
         * Fill Cash Machine with money
         * The Armored car has been arrived
         *
         * @access public
         * @return mixed
         */
        public function loadWithMoney($bills);

        /**
         * Withdraw money from Cash Machine
         * @access public
         * @return mixed
         */
        public function withdrawMoney($amount);

    }