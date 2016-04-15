<?php

namespace CashMachineTest\Service;

use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceManager;
use CashMachine\Bootstrap;

class WithdrawServiceTest extends PHPUnit_Framework_TestCase
{

    private $withdrawService;
    private $availableNotes = [];

    public function __construct()
    {
        $di = Bootstrap::getServiceContainer();
        $this->withdrawService = $di->get('WithdrawService');
        $this->availableNotes = [10, 20, 50, 100];
    }

    public function testService()
    {
        $this->assertInstanceOf('CashMachine\Withdraw\WithdrawService', $this->withdrawService);
    }

    public function testCalculateDeliver()
    {

        $results = $this->withdrawService->calculateDeliver(300, $this->availableNotes);
        $this->assertEquals($results, [100 => 3]);

        $results = $this->withdrawService->calculateDeliver(80, $this->availableNotes);
        $this->assertEquals($results, [50 => 1, 20 => 1, 10 => 1]);

        $results = $this->withdrawService->calculateDeliver(null, $this->availableNotes);
        $this->assertEquals($results, []);
    }

    public function testCalculateDeliverNoteUnavailabelException()
    {
        $this->setExpectedException('CashMachine\Withdraw\NoteUnavailableException');
        $results = $this->withdrawService->calculateDeliver(125, $this->availableNotes);
    }

    public function testCalculateDeliverInvalidArgumentException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $results = $this->withdrawService->calculateDeliver(-130, $this->availableNotes);
    }
}
