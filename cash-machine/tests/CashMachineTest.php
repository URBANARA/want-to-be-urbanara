<?php

//autoload my class
spl_autoload_register(function ($class) {
    include_once dirname(__FILE__)."/../classes/". $class .".php";
});

use PHPUnit\Framework\TestCase;

class CashMachineTest extends TestCase{

    //there should be other test cases, but this is only for purpose of the task
    public function testValue(){

        $m = new CashMachine([100,50,20,10]);

        $result = $m->withdraw(80);

        $this->assertEquals($result,[50.00, 20.00, 10.00]);
    }
}