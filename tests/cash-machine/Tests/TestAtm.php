<?php
    /**
     * TestAtm.php
     * Here we have a few tests not only to show ATM functionality
     * but also helping in documentation
     *
     * @author gustavopereira <gustavoper@gmail.com>
     * @since  2017-02-13 - 22:30
     */
    namespace Tests;

    require __DIR__.'/../vendor/autoload.php';

    use CashMachine\Atm;
    use Exception\InvalidArgumentException;
    use Exception\NoteUnavailableException;

    class TestAtm extends \PHPUnit_Framework_TestCase
    {

        private $atm;

        public function setUp()
        {   //Fill ATM with requested bills (as described in README.md)
            $this->atm = new Atm([100,50,20,10]);
        }

        /**
         * Testing ATM' default behavior
         * which should return simplest possible values
         * @access
         */
        public function testWithdrawing30Bucks()
        {
            $result = $this->atm->withdrawMoney(30);
            $expectedResult = [20,10];
            $this->assertEquals($result,$expectedResult);
        }

        public function testWithdrawing80Bucks()
        {
            $result = $this->atm->withdrawMoney(80);
            $expectedResult = [50,20,10];
            $this->assertEquals($result,$expectedResult);
        }

        public function testWithdrawing190Bucks()
        {
            $result = $this->atm->withdrawMoney(190);
            $expectedResult = [100,50,20,20];
            $this->assertEquals($result,$expectedResult);
        }


        public function testWithdrawing117Bucks()
        {
            $result = $this->atm->withdrawMoney(117);
            $this->assertEquals($result, new NoteUnavailableException());
        }


        public function testWithdrawingZeroBucks()
        {
            $result = $this->atm->withdrawMoney(0);
            $this->assertEquals($result, 0);

        }


        public function testWithdrawingNegativeBucks()
        {
            $result = $this->atm->withdrawMoney(-10);
            $this->assertEquals($result, new InvalidArgumentException());
        }






    }
