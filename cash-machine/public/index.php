<?php

chdir(dirname(__DIR__));

require getcwd() . '/vendor/autoload.php';

use CashMachine\Controller\WithdrawController;
use Slim\Views\PhpRenderer;

$app = new Slim\App();

$container = $app->getContainer();
$container['renderer'] = new PhpRenderer(getcwd() . '/views/');

$app->get('/', function($request, $response) {
    return $this->renderer->render($response, 'home.html');
})->setName('home');

$app->get('/api/v1/withdraw[/[{value}]]', new WithdrawController());

$app->run();
