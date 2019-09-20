<?php

namespace App\Commands;

use App\Exchange\Manager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExchangeList extends Command
{
    protected static $defaultName = 'exchange:list';

    protected function configure()
    {
        $this->setDescription('Get all available exchanges.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $exchanges = Manager::getExchanges();

        foreach ($exchanges as $exchange) {
            $output->writeln($exchange);
        }
    }
}
