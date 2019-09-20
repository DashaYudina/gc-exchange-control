<?php

namespace App\Commands;

use App\Exchange\Manager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddExchange extends Command
{
    protected static $defaultName = 'exchange:add';

    protected function configure()
    {
        $this
            ->setDescription('Adds a new exchange.')
            ->addArgument('name', InputArgument::OPTIONAL)
            ->addArgument('key', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name') ?: $this->ask($input, $output, 'Enter exchange name: ');
        $key = $input->getArgument('key') ?: $this->ask($input, $output, 'Enter exchange key: ');

        if (Manager::addExchange($name, $key)) {
            $output->writeln('<comment>Exchange successfully added.</comment>');
        } else {
            $output->writeln('<error>Error: Could not add exchange.</error>');
        }

    }
}
