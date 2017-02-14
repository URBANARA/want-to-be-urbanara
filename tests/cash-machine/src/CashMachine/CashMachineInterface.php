<?php
    /**
     * Created by PhpStorm.
     *
     * @package
     * @author gustavopereira
     * @since  13/02/17 - 22:16
     */

    namespace CashMachine;


    interface CashMachineInterface
    {

        /**
         * The Armored car has been arrived
         * @access
         * @return mixed
         */
        public function loadWithMoney($bills);

        /**
         *
         * @access
         * @return mixed
         */
        public function withdrawMoney($amount);

    }