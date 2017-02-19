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
    // echo "\033[32m some colored text \033[37m some white text \n";die;

    // $atm = new Atm;
    // echo $atm->withdrawCash(30) . PHP_EOL . PHP_EOL;
    // echo $atm->withdrawCash(80) . PHP_EOL . PHP_EOL;
    // echo $atm->withdrawCash(125) . PHP_EOL . PHP_EOL;
    // echo $atm->withdrawCash(-130) . PHP_EOL . PHP_EOL;
    // echo $atm->withdrawCash(null) . PHP_EOL . PHP_EOL;

    // echo $atm->withdrawCash('250') . PHP_EOL . PHP_EOL;
    // echo $atm->withdrawCash(400) . PHP_EOL . PHP_EOL;
    // echo $atm->withdrawCash(110) . PHP_EOL . PHP_EOL;
    // echo $atm->withdrawCash('60') . PHP_EOL . PHP_EOL;
    // echo $atm->withdrawCash(90) . PHP_EOL . PHP_EOL;

    // echo $atm->withdrawCash('13.5') . PHP_EOL . PHP_EOL;
    // echo $atm->withdrawCash(20.50) . PHP_EOL . PHP_EOL;
    // echo $atm->withdrawCash('lucas') . PHP_EOL . PHP_EOL;
    // echo $atm->withdrawCash() . PHP_EOL . PHP_EOL;
    // echo $atm->withdrawCash(250010) . PHP_EOL . PHP_EOL;