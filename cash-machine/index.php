<?php
    require __DIR__ . '/vendor/autoload.php';

    /**
     * Introduction message
     */
    echo "\n";
    echo "\033[0;36m:: ATM - Cash Withdrawal ::\n";
    echo "\033[37mEnter the amount you would like to withdraw: ";

    /**
     * Client enter the desired amount
     */
    echo "\033[0;32m";
    $handle = fopen ("php://stdin","r");
    $amount = trim(fgets($handle));


    /**
     * Withdraw
     */
    try {
        $atm = new Atm;
        $result = $atm->withdraw($amount);
        echo "\033[37mTake your money: \033[33m" . json_encode($result);
    } catch(Exception $e) {
        echo "\033[31mOps! " . $e->getMessage();
    }

    echo "\n\n";