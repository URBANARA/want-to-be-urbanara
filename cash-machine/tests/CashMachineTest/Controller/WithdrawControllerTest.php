<?php

namespace CashMachineTest\CashMachineTest\Controller;

use PHPUnit_Framework_TestCase;
use CashMachine\Bootstrap;
use CashMachine\Controller\WithdrawController;
use Slim\Route;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Uri;
use Slim\Http\Body;

class WithdrawControllerTest extends PHPUnit_Framework_TestCase
{
    private $withdrawService;
    private $availableNotes = [];

    public function __construct()
    {
        $di = Bootstrap::getServiceContainer();
        $this->withdrawService = $di->get('WithdrawService');
        $this->availableNotes = [10, 20, 50, 100];
    }


    public function testDefaultAction()
    {
        $callable = new WithdrawController();
        $route = new Route(['GET'], '/api/v1/withdraw/', $callable);
        $env = Environment::mock();
        $uri = Uri::createFromString('https://example.com:80');
        $headers = new Headers();
        $cookies = [];
        $serverParams = $env->all();
        $body = new Body(fopen('php://temp', 'r+'));

        $request = new Request('GET', $uri, $headers, $cookies, $serverParams, $body);
        $response = new Response;
        $response = $route->__invoke($request, $response);
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEquals((string) $response->getBody(), '{"notes":[]}');

        $request = $request->withAttribute('value', 300);
        $response = new Response;
        $response = $route->__invoke($request, $response);
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEquals((string) $response->getBody(), '{"notes":{"100":3}}');

        $request = $request->withAttribute('value', 80);
        $response = new Response;
        $response = $route->__invoke($request, $response);
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEquals((string) $response->getBody(), '{"notes":{"50":1,"20":1,"10":1}}');

        $request = $request->withAttribute('value', 125);
        $response = new Response;
        $response = $route->__invoke($request, $response);
        $this->assertEquals($response->getStatusCode(), 500);
        $this->assertEquals((string) $response->getBody(), '{"error":"Note unavailable: 5","unvailableNote":5}');

        $request = $request->withAttribute('value', -130);
        $response = new Response;
        $response = $route->__invoke($request, $response);
        $this->assertEquals($response->getStatusCode(), 500);
        $this->assertEquals((string) $response->getBody(), '{"error":"Value must be greather than 0"}');

        $request = $request->withAttribute('value', null);
        $response = new Response;
        $response = $route->__invoke($request, $response);
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEquals((string) $response->getBody(), '{"notes":[]}');
    }
}
