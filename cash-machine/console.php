<?php

require 'vendor/autoload.php';

use Symfony\Component\Console\Application;
use CashMachine\Withdraw\WithdrawCommand;

$application = new Application();
$application->add(new WithdrawCommand());
$application->run();
