<?php
    namespace Tests;

    require __DIR__ . '/../vendor/autoload.php';

    use Exception\NoteUnavailableException;

    class TestAtm extends \PHPUnit_Framework_TestCase
    {
        private $atm;

        public function setUp()
        {
            $this->atm = new \Atm;
        }

        /**
         * Test the Cash Machine
         */
        public function testWithdraw30() {
            $result = $this->atm->withdraw(30);
            $this->assertEquals($result, [20.00, 10.00]);
        }

        public function testWithdraw80() {
            $result = $this->atm->withdraw(80);
            $this->assertEquals($result, [50.00, 20.00, 10.00]);
        }

        /**
         * @expectedException Exception\NoteUnavailableException
         */
        public function testWithdraw125() {
            $this->atm->withdraw(125);
        }

        /**
         * @expectedException InvalidArgumentException
         */
        public function testWithdrawNegative() {
            $this->atm->withdraw(-130);
        }

        public function testWithdrawNull() {
            $result = $this->atm->withdraw(null);
            $this->assertEquals($result, []);
        }

        /**
         * @expectedException Exception\NoteUnavailableException
         */
        public function testWithdrawDecimal() {
            $this->atm->withdraw(20.50);
        }

        public function testWithdraw250() {
            $result = $this->atm->withdraw(250);
            $this->assertEquals($result, [100.00, 100.00, 50.00]);
        }

        public function testWithdraw400() {
            $result = $this->atm->withdraw(400);
            $this->assertEquals($result, [100.00, 100.00, 100.00, 100.00]);
        }

        public function testWithdraw110() {
            $result = $this->atm->withdraw(110);
            $this->assertEquals($result, [100.00, 10.00]);
        }

        public function testWithdraw60String() {
            $result = $this->atm->withdraw('60');
            $this->assertEquals($result, [50.00, 10.00]);
        }

        public function testWithdraw90() {
            $result = $this->atm->withdraw(90);
            $this->assertEquals($result, [50.00, 20.00, 20.00]);
        }

        /**
         * @expectedException InvalidArgumentException
         */
        public function testWithdrawTextString() {
            $this->atm->withdraw('urbanara');
        }
    }