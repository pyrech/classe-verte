<?php

namespace App;

class EstCeQueCEst
{
    const MORE_THAN_30_DAYS = '30j+';
    const MORE_THAN_14_DAYS = '14j+';
    const MORE_THAN_7_DAYS = '7j+';
    const MORE_THAN_3_DAYS = '3j+';
    const MORE_THAN_2_DAYS = '2j+';
    const MORE_THAN_24_HOURS = '24h+';
    const MORE_THAN_12_HOURS = '12h+';
    const MORE_THAN_6_HOURS = '6h+';
    const MORE_THAN_1_HOUR = '1h+';
    const LESS_THAN_1_HOUR = '1h-';
    const IT_S_NOW = 'now';
    const IT_S_OVER = 'over';

    /** @var \DateTime */
    private $start;

    /** @var \DateTime */
    private $end;

    public function __construct(string $start, string $end)
    {
        $this->start = new \DateTime($start);
        $this->end = new \DateTime($end);
    }

    /**
     * @internal \DateTime $now
     */
    public function bientotLaClasseVerte(\DateTime $now = null): string
    {
        $now = $now ?: new \DateTime();

        if ($now > $this->end) {
            // Classe Verte has ended today
            if ($now->format('Y-m-d') === $this->end->format('Y-m-d')) {
                return self::IT_S_OVER;
            }

            // Next Classe Verte dates have not been setted yet
            return self::MORE_THAN_30_DAYS;
        }

        if ($this->start <= $now && $now <= $this->end) {
            return self::IT_S_NOW;
        }

        // Normal counter

        $diff = $now->diff($this->start);

        if ($diff->days > 30) {
            return self::MORE_THAN_30_DAYS;
        }

        if ($diff->days > 14) {
            return self::MORE_THAN_14_DAYS;
        }

        if ($diff->days > 7) {
            return self::MORE_THAN_7_DAYS;
        }

        if ($diff->days > 3) {
            return self::MORE_THAN_3_DAYS;
        }

        if ($diff->days > 2) {
            return self::MORE_THAN_2_DAYS;
        }

        if (($diff->days * 24 + $diff->h) > 24) {
            return self::MORE_THAN_24_HOURS;
        }

        if ($diff->h > 12) {
            return self::MORE_THAN_12_HOURS;
        }

        if ($diff->h > 6) {
            return self::MORE_THAN_6_HOURS;
        }

        if ($diff->h > 1) {
            return self::MORE_THAN_1_HOUR;
        }

        return self::LESS_THAN_1_HOUR;
    }

    public function getRemainingDays(\DateTime $now = null): int
    {
        $now = $now ?: new \DateTime();

        $diff = $now->diff($this->start);

        return (int) $diff->days;
    }
}
