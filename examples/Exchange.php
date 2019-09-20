<?php


namespace Examples;

use App\Exchange\ExchangeInterface;

class Exchange implements ExchangeInterface
{
    /** @var string */
    private $name;

    /** @var string */
    private $key;

    /** @var array|mixed */
    private $balance = [];

    /**
     * Exchange constructor.
     *
     * @param string $name
     * @param string $key
     */
    public function __construct(string $name, string $key)
    {
        $this->name = $name;
        $this->key = $key;

        $this->balance = ApiExchangeExample::initBalance();
    }

    /**
     * Get value price
     *
     * @param string $type
     * @return float
     */
    public function getPrice(string $type): float
    {
        return ApiExchangeExample::getPrice($type);
    }

    /**
     * Buy currency
     *
     * @param string $type
     * @param float $value
     */
    public function buy(string $type, float $value): void
    {
        $this->balance = ApiExchangeExample::buy($this->balance, $type, $value);
    }

    /**
     * Get exchange balance
     *
     * @return array
     */
    public function getBalances(): array
    {
        return $this->balance;
    }

    /**
     * Get exchange name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set exchange name
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get exchange key
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Set exchange key
     *
     * @param string $key
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    /**
     * Convert exchange values to string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }
}
