<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Services\Account\AccountOperationService;
use App\Services\Account\OperationFactory;
use Illuminate\Validation\Validator;
use App\Services\Account\Contracts\AccountOperationStrategyInterface;
use Mockery as m;

class AccountOperationServiceTest extends TestCase
{
    /**
     * Instantiate AccountOperationService successfully
     *
     * @return void
     */
    public function testAccountOperationService()
    {
        $accountService = new AccountOperationService(
            $this->getRequest(),
            new OperationFactory()
        );

        $this->assertTrue($accountService->hasValidData());
        $this->assertInstanceOf(
            'Illuminate\Validation\Validator',
            $accountService->getValidator()
        );
        $this->assertEquals(
            $accountService->processOperation(),
            [
                '100' => 9,
                '50'  => 1,
                '20'  => 1,
                '10'  => 1
            ]
        );
    }

    /**
     * Instantiate AccountOperationService with input cash and remainders
     */
    public function testAccountOperationServiceWithRemainder()
    {
        $accountService = new AccountOperationService(
            $this->getRequestWithCashAndRemainders(),
            new OperationFactory()
        );

        $accountService->hasValidData();
        $accountService->processOperation();
        $this->assertEquals(
            $accountService->getMessages(),
            [ 0 => 'There are no bank notes available to make up the amount requested']
        );
    }

    /**
     * Instantiate AccountOperationService with negative input cash
     */
    public function testAccountOperationServiceWithNegativeCash()
    {
        $accountService = new AccountOperationService(
            $this->getRequestWithNegativeCash(),
            new OperationFactory()
        );

        $accountService->hasValidData();
        $accountService->processOperation();
        $this->assertEquals(
            $accountService->getMessages(),
            [ 0 => 'The amount requested can not be less than zero']
        );
    }

    /**
     * Instantiate AccountOperationService without input operation
     */
    public function testAccountOperationServiceWithNoInputOperation()
    {
        $accountService = new AccountOperationService(
            $this->getRequestWithNoOperationValue(),
            new OperationFactory()
        );

        $accountService->hasValidData();
        $this->assertEquals(
            $accountService->getValidator()->errors()->first('operation'),
            'The operation field is required.'
        );
    }

    /**
     * Instantiate AccountOperationService without input operation
     */
    public function testAccountOperationServiceWithNoIndexOperation()
    {
        $accountService = new AccountOperationService(
            $this->getRequestWithNoIndexOperation(),
            new OperationFactory()
        );

        $accountService->hasValidData();
        $this->assertEquals(
            $accountService->getValidator()->errors()->get('operation'),
            [
                0 => 'The operation field is required.',
                1 => 'The requested operation can not be null'
            ]
        );
    }

    /**
     * Mock a request with complete inputs
     * @return Illuminate\Http\Request
     */
    private function getRequest()
    {
        return $this->mockRequest(
            [
                'operation' => 'withdraw',
                'cash' => '980.00'
            ]
        );
    }

    private function getRequestWithCashAndRemainders()
    {
        return $this->mockRequest(
            [
                'operation' => 'withdraw',
                'cash' => '675.00'
            ]
        );
    }

    /**
     * Mock a request with no input operation value
     * @return Illuminate\Http\Request
     */
    private function getRequestWithNoOperationValue()
    {
        return $this->mockRequest(['operation' => '', 'cash' => '321312']);
    }

    /**
     * Mock a request with no input operation value
     * @return Illuminate\Http\Request
     */
    private function getRequestWithNegativeCash()
    {
        return $this->mockRequest(['operation' => 'withdraw', 'cash' => '-160']);
    }

    /**
     * Mock a request with no index operation
     * @return Illuminate\Http\Request
     */
    private function getRequestWithNoIndexOperation()
    {
        return $this->mockRequest(['cash' => '321312']);
    }

    /**
     * Template of a Mock Request
     * @return Illuminate\Http\Request
     */
    private function mockRequest(array $arrayData)
    {
        $request = m::mock('Illuminate\Http\Request');
        $request->shouldReceive('input')
            ->with('operation')
            ->andReturn(
                isset($arrayData['operation'])
                ? $arrayData['operation']
                : null
            );
        $request->shouldReceive('input')
            ->with('cash')
            ->andReturn(
                isset($arrayData['cash'])
                ? $arrayData['cash']
                : null
            );
        $request
            ->shouldReceive('all')
            ->andReturn($arrayData);

        return $request;
    }

    /**
     * Mock a validator
     * @return Illuminate\Validation\Validator
     */
    private function validator()
    {
        $validator = m::mock('Illuminate\Validation\Validator');

        return $validator;
    }

    /**
     * Mock a strategy
     * @return App\Services\Account\Contracts\AccountOperationStrategyInterface
     */
    private function strategy()
    {
        $strategy = m::mock('App\Services\Account\Contracts\AccountOperationStrategyInterface');

        return $strategy;
    }
}
