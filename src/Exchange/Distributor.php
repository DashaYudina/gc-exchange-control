<?php


namespace App\Exchange;


class Distributor
{
    /**
     * Calculate new exchange balance
     *
     * @param array $balance
     * @param float $rubusd
     * @param float $eurusd
     * @param array $newPercentages
     * @return array
     */
    public function distributeBalance(array $balance, float $rubusd, float $eurusd, array $newPercentages)
    {
        $rubBalanceInUsd = $this->toUsd($balance['RUB'], $rubusd);
        $eurBalanceInUsd = $this->toUsd($balance['EUR'], $eurusd);
        $balanceInUsd = $balance['USD'] + $rubBalanceInUsd + $eurBalanceInUsd;

        $percentages = $this->determinePercentages(
            ['USD' => $balance['USD'], 'RUB' => $rubBalanceInUsd, 'EUR' => $eurBalanceInUsd],
            $balanceInUsd
        );

        $newBalance = $this->getExpectedBalance($balance, $percentages, $newPercentages);

        return $this->calculateDiffBalance($newBalance, $balance);
    }

    /**
     * Convert currency to USD
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
     * Calculate difference between current percentage balance and new percentage balance
     *
     * @param array $newBalance
     * @param array $oldBalance
     * @return array
     */
    private function calculateDiffBalance(array $newBalance, array $oldBalance)
    {
        return [
            'USD' => $newBalance['USD'] - $oldBalance['USD'],
            'RUB' => $newBalance['RUB'] - $oldBalance['RUB'],
            'EUR' => $newBalance['EUR'] - $oldBalance['EUR'],
        ];
    }

    /**
     * Get expected exchange balance
     *
     * @param array $balance
     * @param array $percentages
     * @param array $newPercentages
     * @return array
     */
    private function getExpectedBalance(array $balance, array $percentages, array $newPercentages): array
    {
        return [
            'USD' => $this->calculateBalance($balance['USD'], $percentages[0], $newPercentages[0]),
            'RUB' => $this->calculateBalance($balance['RUB'], $percentages[1], $newPercentages[1]),
            'EUR' => $this->calculateBalance($balance['EUR'], $percentages[2], $newPercentages[2])
        ];

    }

    /**
     * Calculate balance
     *
     * @param float $value
     * @param float $percentage
     * @param float $newPercentage
     * @return float|int
     */
    private function calculateBalance(float $value, float $percentage, float $newPercentage)
    {
        return $percentage ? $value * $newPercentage / $percentage : 0;
    }

    /**
     * Calculate current exchange percentages
     *
     * @param array $balance
     * @param float $balanceInUsd
     * @return array
     */
    private function determinePercentages(array $balance, float $balanceInUsd)
    {
        return $balanceInUsd ? [
            100 * $balance['USD'] / $balanceInUsd,
            100 * $balance['RUB'] / $balanceInUsd,
            100 * $balance['EUR'] / $balanceInUsd
        ] : [];
    }
}
