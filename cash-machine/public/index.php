<?php

chdir(dirname(__DIR__));

require getcwd() . '/vendor/autoload.php';

use CashMachine\Controller\WithdrawController;

$app = new Slim\App();

$app->get('/api/v1/withdraw[/[{value}]]', new WithdrawController());

$app->run();
