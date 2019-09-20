<?php


namespace App\Exchange;

/**
 * Interface ExchangeInterface
 * @package App\Exchange
 */
interface ExchangeInterface extends ApiExchangeInterface
{
    /**
     * Get exchange name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Set exchange name
     * @param string $name
     */
    public function setName(string $name): void;

    /**
     * Get exchange key
     *
     * @return string
     */
    public function getKey(): string;

    /**
     * Set exchange key
     *
     * @param string $key
     */
    public function setKey(string $key): void;
}
