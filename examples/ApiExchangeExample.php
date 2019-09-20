<?php


namespace Examples;


class ApiExchangeExample
{
    /** @var array */
    private static $percentages = [15, 45, 40];

    /** @var int */
    private static $usdrub = 60;

    /** @var float */
    private static $usdeur = 0.9;

    /**
     * Initialize exchange balance
     *
     * @return mixed
     */
    public static function initBalance() {
        $value = rand(1000, 10000);

        $balance['USD'] = self::$percentages[0] * $value / 100;
        $balance['RUB'] = self::$percentages[1] * $value / 100 * self::$usdrub;
        $balance['EUR'] = self::$percentages[2] * $value / 100 * self::$usdeur;

        return $balance;
    }

    /**
     * Get currency price
     *
     * @param string $type
     * @return float
     */
    public static function getPrice(string $type): float
    {
        if ($type === 'RUBUSD') {
            return self::$usdrub ? 1 / self::$usdrub : 1;
        } elseif ($type === 'EURUSD') {
            return self::$usdeur ? 1 / self::$usdeur : 1;
        }

        return 1;
    }

    /**
     * Buy currency
     *
     * @param array $balance
     * @param string $type
     * @param float $value
     * @return array
     */
    public static function buy(array $balance, string $type, float $value): array
    {
        if ($type === 'RUBUSD') {
            $cost = $value * self::$usdrub;

            $balance['RUB'] -= $cost;
            $balance['USD'] += $value;
        } elseif ($type === 'USDRUB') {
            $cost = $value / self::$usdrub;

            $balance['RUB'] += $value;
            $balance['USD'] -= $cost;
        } elseif ($type === 'EURUSD') {
            $cost = $value * self::$usdeur;

            $balance['EUR'] -= $cost;
            $balance['USD'] += $value;
        } elseif ($type === 'USDEUR') {
            $cost = $value / self::$usdeur;

            $balance['EUR'] += $value;
            $balance['USD'] -= $cost;
        }

        return $balance;
    }

    /**
     * Get exchange balance
     *
     * @return array
     */
    public static function getBalances(): array
    {
        return self::initBalance();
    }
}
