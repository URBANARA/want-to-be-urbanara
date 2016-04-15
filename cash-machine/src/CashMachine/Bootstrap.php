<?php

namespace CashMachine;

use Zend\ServiceManager\ServiceManager;

class Bootstrap
{
    private static $container;

    public static function getServiceContainer()
    {
        if (self::$container === null) {
            $config = include  getcwd() . '/config/withdraw.config.php';
            $serviceManager = new ServiceManager([
                'factories' => [
                    'WithdrawConfig' => function () use ($config) {
                        return (object) $config['withdraw'];
                    }
                ],
                'invokables' => [
                    'WithdrawService' =>'CashMachine\\Withdraw\\WithdrawService'
                ]
            ]);
            self::$container = $serviceManager;
        }

        return self::$container;
    }
}
