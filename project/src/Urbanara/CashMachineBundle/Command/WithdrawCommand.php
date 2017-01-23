<?php

namespace Urbanara\CashMachineBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class WithdrawCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('cashmachine:withdraw')
            ->setDescription('Withdraw money from an account')
            ->addArgument('amount', InputArgument::REQUIRED, 'Amount');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cashmachine = $this->getContainer()->get('cashmachine');
        $amount = $input->getArgument('amount');

        $withdraw = implode(', ', $cashmachine->checkNotes($amount));

        $output->writeln("Amount: {$amount}\nNotes: {$withdraw}");
    }

}
