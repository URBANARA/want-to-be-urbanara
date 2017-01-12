<?php

namespace App\Services\Account;

use Illuminate\Validation\Validator;
use App\Services\Account\Contracts\AccountOperationInterface;
use App\Services\Account\Contracts\OperationFactoryInterface;
use App\Services\Account\Contracts\AccountOperationStrategyInterface;
use App\Services\Account\Exceptions\OperationNotFoundException;
use Illuminate\Http\Request;

class AccountOperationService implements AccountOperationInterface
{
    /**
     * @var Illuminate\Http\Request
     */
    private $request;

    /**
     * @var Illuminate\Validation\Validator
     */
    private $validator;

    /**
     * @var App\Services\Account\Contracts\AccountOperationStrategyInterface
     */
    private $operationStrategy;

    /**
     * @var App\Services\Account\Contracts\OperationFactoryInterface
     */
    private $factory;

    /**
     * @var array
     */
    private $messages = [];

    /**
     * [__constructor]
     * @param Illuminate\Http\Request $request
     * @param App\Services\Account\Contracts\OperationFactoryInterface $factory
     */
    public function __construct(
        Request $request,
        OperationFactoryInterface $factory
    ) {
        $this->request = $request;
        $this->factory = $factory;

        $this->instantiateDependencies();
    }

    /**
     * [hasValidData Uses validator to check requested data]
     * @return boolean
     */
    public function hasValidData()
    {
        return ! $this->validator->fails();
    }

    /**
     * [processOperation execute requested operation]
     * @return [type] [description]
     */
    public function processOperation() {
        return $this->getStrategy()->processOperation();
    }

    /**
     * @return Illuminate\Validation\Validator
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * [getMessages]
     * @return [array]
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * [setMessages]
     * @param [string] $message
     */
    public function setMessages($message)
    {
        array_push($this->messages, $message);
    }

    /**
     * @param App\Services\Account\Contracts\AccountOperationStrategyInterface $strategy
     */
    private function setStrategy(AccountOperationStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * @return App\Services\Account\Contracts\AccountOperationStrategyInterface
     */
    private function getStrategy()
    {
        return $this->strategy;
    }

    /**
     * @param Illuminate\Validation\Validator $validator
     */
    private function setValidator(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * [instantiateDependencies set Validator and Strategy]
     * @return null
     */
    private function instantiateDependencies()
    {
        $this->setValidator(
            $this->factory->getValidatorFromRequest($this->request)
        );
        try {
            $this->setStrategy(
                $this->factory->getStrategyFromRequest($this->request)
            );
        } catch (OperationNotFoundException $e) {
            $this->getValidator()->after(function($validator) use ($e) {
                $validator->errors()->add('operation', $e->getMessage());
            });
        }
    }
}
