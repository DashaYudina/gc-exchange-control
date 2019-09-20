<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;
use App\Commands\AddExchange;
use App\Commands\DeleteExchange;
use App\Commands\UpdateExchange;
use App\Commands\ExchangeList;

const MAIN_DIR_NAME = __DIR__;

$application = new Application();

$application->add(new AddExchange());
$application->add(new DeleteExchange());
$application->add(new UpdateExchange());
$application->add(new ExchangeList());

$application->run();
