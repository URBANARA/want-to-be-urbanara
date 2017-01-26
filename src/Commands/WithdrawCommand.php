<?php

namespace Urbanara\CashMachine\Command;

use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Urbanara\CashMachine\Enum\Currency\BrazilianRealEnum;
use Urbanara\CashMachine\Enum\Currency\EuropeanEuroEnum;
use Urbanara\CashMachine\Enum\Currency\UnitedStatesDollarEnum;
use Urbanara\CashMachine\Factory\CurrencyNoteFactory;
use Urbanara\CashMachine\Service\CashMachine;
use Urbanara\CashMachine\Service\LowestAmountPossibleCalculator;

/**
 * @author  Alexandre Rodrigues Xavier <alexandre.rodrigues.xv@gmail.com>
 *
 * @package Urbanara\CashMachine\Command
 */
class WithdrawCommand extends Command
{
    /**
     * @var \Urbanara\CashMachine\Service\CashMachine
     */
    private $cacheMachine;

    /**
     * @var \Urbanara\CashMachine\Entity\Currency
     */
    private $currency;

    /**
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    private $output;

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName('urbanara:cache-machine:withdraw')
            ->setDescription('Withdraw')
            ->addArgument('amount', InputArgument::REQUIRED)
            ->addOption(
                'currency',
                'c',
                InputOption::VALUE_OPTIONAL,
                sprintf(
                    'Currency ISO-4217 code (available: %s)',
                    implode(
                        ', ',
                        [
                            BrazilianRealEnum::ISO_4217,
                            EuropeanEuroEnum::ISO_4217,
                            UnitedStatesDollarEnum::ISO_4217,
                        ]
                    )
                ),
                BrazilianRealEnum::ISO_4217
            )
        ;
    }

    /**
     * Initializes the command just after the input has been validated.
     *
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $currencyNoteFactory = new CurrencyNoteFactory();

        $currencyNote = $currencyNoteFactory->buildByIso4217Code(
            $input->getOption('currency')
        );

        $this->cacheMachine = new CashMachine(
            new LowestAmountPossibleCalculator(),
            $currencyNote
        );

        $this->currency = $currencyNote->getCurrency();
        $this->output = $output;

        $this->keyValueOutput('Currency', $this->currency->getName());
        $this->keyValueOutput(
            'Available notes',
            implode(
                ', ',
                $this->transformFloatArrayToStringArray(
                    $currencyNote->getAvailableValues(),
                    $this->currency->getSymbol()
                )
            )
        );
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return null|int null or 0 if everything went fine, or an error code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $amount = $input->getArgument('amount');

        if (!is_numeric($amount)) {
            throw new InvalidArgumentException('Amount must be numeric');
        }

        $withdraw = $this->cacheMachine->withdraw($amount);

        $this->keyValueOutput(
            'Withdraw',
            implode(
                ', ',
                $this->transformFloatArrayToStringArray(
                    $withdraw,
                    $this->currency->getSymbol()
                )
            )
        );

        return 0;
    }

    /**
     * @param string $label
     * @param string $value
     */
    private function keyValueOutput($label, $value)
    {
        $this->output->writeln([
            sprintf(
                '<options=bold>%s: </>%s',
                $label,
                $value
            )
        ]);
    }

    /**
     * @param float[] $array
     * @param string  $prefix
     *
     * @return array
     */
    private function transformFloatArrayToStringArray(array $array, $prefix)
    {
        $string = [];

        foreach ($array as $floatValue) {
            $string [] = sprintf(
                '%s %0.2f',
                $prefix,
                $floatValue
            );
        }

        return $string;
    }
}
