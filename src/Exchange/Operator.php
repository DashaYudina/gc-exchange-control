<?php


namespace App\Exchange;


class Operator
{
    /** @var Distributor */
    private $distributor;

    /**
     * ExchangeOperator constructor.
     */
    public function __construct()
    {
        $this->distributor = new Distributor();
    }

    /**
     * Change percent ration for exchange
     *
     * @param ExchangeInterface $exchange Exchange
     * @param array $newPercentages New percentages
     * @return array
     */
    public function changeBalanceForExchange(ExchangeInterface $exchange, array $newPercentages): array
    {
        $balance = $exchange->getBalances();
        $rubusd = $exchange->getPrice('RUBUSD');
        $eurusd = $exchange->getPrice('EURUSD');

        $diffBalance = $this->distributor->distributeBalance($balance, $rubusd, $eurusd, $newPercentages);

        return $this->changeBalance($exchange, $diffBalance, $rubusd, $eurusd);
    }

    /**
     * Change percent ration for exchange
     *
     * @param ExchangeInterface $exchange
     * @param array $diffBalance Difference between current percentages and new percentages
     * @param float $rubusd Ratio RUB to USD
     * @param float $eurusd Ratio EUR to USD
     * @return array
     */
    private function changeBalance(ExchangeInterface $exchange, array $diffBalance, float $rubusd, float $eurusd): array
    {
        $this->buy($exchange, $diffBalance['RUB'], 'RUB', $rubusd);
        $this->buy($exchange, $diffBalance['EUR'], 'EUR', $eurusd);

        return $exchange->getBalances();
    }

    /**
     * Convert value to USD
     *
     * @param float $value
     * @param float $ration
     * @return float|int
     */
    private function toUsd(float $value, float $ration)
    {
        return $value * $ration;
    }

    /**
     * Buy values via exchange api
     *
     * @param ExchangeInterface $exchange
     * @param float $value
     * @param string $type
     * @param float $ratio
     */
    private function buy(ExchangeInterface $exchange, float $value, string $type, float $ratio)
    {
        if ($value < 0) {
            $exchange->buy($type . 'USD', $this->toUsd(abs($value), $ratio));
        } else {
            $exchange->buy('USD' . $type, $value);
        }
    }
}
