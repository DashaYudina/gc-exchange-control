<?php

namespace App\Commands;

use App\Exchange\Manager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateExchange extends Command
{
    protected static $defaultName = 'exchange:update';

    protected function configure()
    {
        $this->setDescription('Updates exchange.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $percentages = $this->getNewPercentagesRate($input, $output);

        Manager::updateRates($percentages);

        $output->writeln('<comment>Percentages updated successfully.</comment>');
    }

    private function getNewPercentagesRate(InputInterface $input, OutputInterface $output)
    {
        $isValidInputData = false;
        $usd = 0;
        $rub = 0;
        $eur = 0;

        while (!$isValidInputData) {
            $usd = (int)$this->ask($input, $output, 'Enter a new percentage for USD: ');
            $rub = (int)$this->ask($input, $output, 'Enter a new percentage for RUB: ');
            $eur = (int)$this->ask($input, $output, 'Enter a new percentage for EUR: ');


            if (!$this->isValidInputData($usd)) {
                $output->writeln('<error>Incorrect USD percentage.</error>');

                $isValidInputData = false;

                continue;
            }

            if (!$this->isValidInputData($rub)) {
                $output->writeln('<error>Incorrect RUB percentage.</error>');

                $isValidInputData = false;

                continue;
            }

            if (!$this->isValidInputData($eur)) {
                $output->writeln('<error>Incorrect EUR percentage.</error>');

                $isValidInputData = false;

                continue;
            }

            if ($usd + $rub + $eur !== 100) {
                $output->writeln('<error>Incorrect percentages (sum != 100).</error>');

                $isValidInputData = false;

                continue;
            }

            $isValidInputData = true;
        }

        return [$usd, $rub, $eur];
    }

    private function isValidInputData(int $value)
    {
        return $value >= 0 && $value <= 100;
    }
}
