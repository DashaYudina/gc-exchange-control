<?php

namespace App\Exchange;

use App\Storage;
use Examples\Exchange;

class Manager
{
    private static $instance;

    /** @var ExchangeInterface[] */
    private $exchanges;

    /**
     * Manager constructor.
     */
    protected function __construct()
    {
        $this->exchanges = Storage::read();
    }

    /**
     * Disable object clone
     */
    protected function __clone()
    {
    }

    /**
     * Get Manager instance
     *
     * @return Manager
     */
    protected static function getInstance(): Manager
    {
        return static::$instance ?? new Manager();
    }

    /**
     * Add exchange to storage
     *
     * @param string $name Exchange name
     * @param string $key Exchange key
     * @return bool
     */
    public static function addExchange(string $name, string $key): bool
    {
        $manager = self::getInstance();

        $manager->exchanges[$name] = new Exchange($name, $key);

        return $manager->saveExchanges($manager->exchanges);
    }

    /**
     * Delete exchange from storage
     *
     * @param string $name Exchange name
     * @return bool
     */
    public static function deleteExchange(string $name): bool
    {
        $manager = self::getInstance();

        if (array_key_exists($name, $manager->exchanges)) {
            unset($manager->exchanges[$name]);

            return $manager->saveExchanges($manager->exchanges);
        }

        return false;
    }

    /**
     * Get all exchanges
     *
     * @return array
     */
    public static function getExchanges(): array
    {
        $manager = self::getInstance();

        return $manager->exchanges;
    }

    /**
     * Get all exchanges name
     *
     * @return array
     */
    public static function getExchangesName(): array
    {
        $manager = self::getInstance();

        return array_keys($manager->exchanges);
    }

    /**
     * Update exchanges percentages
     *
     * @param array $percentages
     */
    public static function updateRates(array $percentages): void
    {
        $manager = self::getInstance();

        $operator = new Operator();

        foreach ($manager->exchanges as $exchange) {
            $manager->printBalance($exchange, $exchange->getBalances());

            $balance = $operator->changeBalanceForExchange($exchange, $percentages);

            $manager->printBalance($exchange, $balance, 'New balance');
        }
    }

    /**
     * Save exchange to storage
     *
     * @param array $exchanges
     * @return bool
     */
    private function saveExchanges(array $exchanges)
    {
        return Storage::write($exchanges);
    }

    /**
     * Print balance
     *
     * @param string $exchangeName
     * @param array $balance
     * @param string $message
     */
    private function printBalance(string $exchangeName, array $balance, string $message = 'Current balance') {
        echo "----------------------------------------\n";
        echo $exchangeName . ': ' . $message . "\n";
        echo 'USD = ' . $balance['USD'] . ' ';
        echo 'RUB = ' . $balance['RUB'] . ' ';
        echo 'EUR = ' . $balance['EUR'] . "\n";
    }
}
