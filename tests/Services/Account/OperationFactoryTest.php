<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Services\Account\OperationFactory;
use Mockery as m;

class OperationFactoryTest extends TestCase
{
    /**
     * Tests for Instantiate OperationFactory succesfully.
     *
     * @return void
     */
    public function testOperationFactory()
    {
        $request    = $this->getRequestWithOperation();

        $factory    = new OperationFactory();

        $this->assertInstanceOf(
            'Illuminate\Validation\Validator',
            $factory->getValidatorFromRequest($request)
        );
        $this->assertInstanceOf(
            'App\Services\Account\Contracts\AccountOperationStrategyInterface',
            $factory->getStrategyFromRequest($request)
        );
    }

    /**
     * Test should create a Validator when Request operation is empty.
     *
     * @return void
     */
    public function testFactoryShouldCreateValidatorEvenWhenRequestOperationEmpty()
    {
        $request    = $this->getRequestWithNoOperation();

        $factory    = new OperationFactory();

        $this->assertInstanceOf(
            'Illuminate\Validation\Validator',
            $factory->getValidatorFromRequest($request)
        );
    }

    /**
     * Test OperationNotFoundException when create Strategy and Request operation is empty.
     *
     * @expectedException App\Services\Account\Exceptions\OperationNotFoundException
     *
     * @return void
     */
    public function testFactoryShouldThrowExceptionWhenCreateStrategyWithRequestOperationEmpty()
    {
        $request    = $this->getRequestWithNoOperation();

        $factory    = new OperationFactory();

        $this->assertInstanceOf(
            'App\Services\Account\Contracts\AccountOperationStrategyInterface',
            $factory->getStrategyFromRequest($request)
        );
    }

    /**
     * Test should create Validator even when and Request operation is null.
     *
     * @return void
     */
    public function testFactoryShouldCreateValidatorWithRequestOperationNull()
    {
        $request    = $this->getRequestWithOperationNull();

        $factory    = new OperationFactory();

        $this->assertInstanceOf(
            'Illuminate\Validation\Validator',
            $factory->getValidatorFromRequest($request)
        );
    }

    /**
     * Test OperationNotFoundException when create Strategy and Request operation is null.
     *
     * @expectedException App\Services\Account\Exceptions\OperationNotFoundException
     *
     * @return void
     */
    public function testFactoryShouldThrowExceptionWhenCreateStrategyWithRequestOperationNull()
    {
        $request    = $this->getRequestWithOperationNull();

        $factory    = new OperationFactory();

        $this->assertInstanceOf(
            'App\Services\Account\Contracts\AccountOperationStrategyInterface',
            $factory->getStrategyFromRequest($request)
        );
    }

    private function getRequestWithOperation()
    {
        $request = m::mock('Illuminate\Http\Request');
        $request->shouldReceive('input')->with('operation')->andReturn('withdraw');
        $request->shouldReceive('all')->andReturn([]);

        return $request;
    }

    private function getRequestWithNoOperation()
    {
        $request = m::mock('Illuminate\Http\Request');
        $request->shouldReceive('input')->with('operation')->andReturn('');
        $request->shouldReceive('all')->andReturn([]);

        return $request;
    }

    private function getRequestWithOperationNull()
    {
        $request = m::mock('Illuminate\Http\Request');
        $request->shouldReceive('input')->with('operation')->andReturn(null);
        $request->shouldReceive('all')->andReturn([]);

        return $request;
    }
}
