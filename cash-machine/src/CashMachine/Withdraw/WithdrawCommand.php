<?php

namespace CashMachine\Withdraw;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use CashMachine\Bootstrap;

class WithdrawCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('withdraw')
            ->setDescription('Calculate the best way to delivery notes in a withdraw')
            ->addArgument(
                'value',
                InputArgument::REQUIRED,
                'Value to the withdraw'
            )
            ->addOption(
                'amount',
                null,
                InputOption::VALUE_NONE,
                'Display amount'
            )
            ->addOption(
                'pretty',
                null,
                InputOption::VALUE_NONE,
                'Friendly output'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $value = $input->getArgument('value');
        $pretty = $input->getOption('pretty');
        $displayAmount = $input->getOption('amount');

        $di = Bootstrap::getServiceContainer();
        $config = $di->get('WithdrawConfig');
        $withdrawService = $di->get('WithdrawService');

        $results = $withdrawService->calculateDeliver($value, $config->availableNotes);

        if ($displayAmount) {
            $output->writeln('<info>Amount:</> <comment>' . number_format($value, 2) . '</>');
        }
        if ($pretty) {
            $output->writeln('<info>Result: [</>');
            foreach ($results as $note => $repeat) {
                if ($repeat === 0) {
                    continue;
                }
                $output->writeln('  <comment>' . $repeat . ' x ' . number_format($note, 2) . '</>');
            }
            $output->writeln('<info>]</>');
        } else {
            $outputResult = [];
            foreach ($results as $note => $repeat) {
                $outputResult = array_merge($outputResult, array_pad([], $repeat, $note));
            }
            $output->writeln('<info>Result: [</><comment>' . implode($outputResult, ', ') . '</><info>]</>');
        }
    }
}
