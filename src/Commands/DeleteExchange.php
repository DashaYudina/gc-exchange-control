<?php

namespace App\Commands;

use App\Exchange\Manager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteExchange extends Command
{
    protected static $defaultName = 'exchange:delete';

    protected function configure()
    {
        $this
            ->setDescription('Delete exchange.')
            ->addArgument('name', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name') ?: $this->choice($input, $output, 'Select item', Manager::getExchangesName());

        if (Manager::deleteExchange($name)) {
            $output->writeln('<comment>Exchange successfully deleted.</comment>');
        } else {
            $output->writeln('<error>Error: Could not delete exchange.</error>');
        }
    }
}
