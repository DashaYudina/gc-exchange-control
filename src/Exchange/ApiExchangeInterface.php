<?php


namespace App\Exchange;


interface ApiExchangeInterface
{
    /**
     * Get price for currency
     *
     * @param string $type Type of currency
     * @return float
     */
    public function getPrice(string $type): float;

    /**
     * Buy currency
     *
     * @param string $type Type of operation
     * @param float $value Count of currency
     */
    public function buy(string $type, float $value): void;

    /**
     * Get exchange balance
     *
     * @return array
     */
    public function getBalances(): array;
}
