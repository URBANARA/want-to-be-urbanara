<?php

//autoload my class
spl_autoload_register(function ($class) {
    include_once $_SERVER['DOCUMENT_ROOT']."/want-to-be-urbanara/cash-machine/classes/". $class .".php";
});

$machine = new CashMachine([100,50,20,10]);

$result = $machine->withdraw(270);

print_r($result);