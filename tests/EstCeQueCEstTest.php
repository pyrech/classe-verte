<?php

namespace App\Tests;

use App\EstCeQueCEst;
use PHPUnit\Framework\TestCase;

class EstCeQueCEstTest extends TestCase
{
    /** @var EstCeQueCEst */
    private $estCeQueCEst;

    protected function setUp(): void
    {
        $this->estCeQueCEst = new EstCeQueCEst(
            '2017-09-20 18:00:00',
            '2017-09-24 18:00:00'
        );
    }

    public function testItWorksWithoutAnyBug()
    {
        self::assertSame(
            EstCeQueCEst::MORE_THAN_60_DAYS,
            $this->estCeQueCEst->bientotLaClasseVerte(new \DateTime('2017-07-15 12:00:00'))
        );
        self::assertSame(
            EstCeQueCEst::MORE_THAN_30_DAYS,
            $this->estCeQueCEst->bientotLaClasseVerte(new \DateTime('2017-08-15 12:00:00'))
        );
        self::assertSame(
            EstCeQueCEst::MORE_THAN_14_DAYS,
            $this->estCeQueCEst->bientotLaClasseVerte(new \DateTime('2017-09-01 12:00:00'))
        );
        self::assertSame(
            EstCeQueCEst::MORE_THAN_7_DAYS,
            $this->estCeQueCEst->bientotLaClasseVerte(new \DateTime('2017-09-08 12:00:00'))
        );
        self::assertSame(
            EstCeQueCEst::MORE_THAN_3_DAYS,
            $this->estCeQueCEst->bientotLaClasseVerte(new \DateTime('2017-09-15 12:00:00'))
        );
        self::assertSame(
            EstCeQueCEst::MORE_THAN_2_DAYS,
            $this->estCeQueCEst->bientotLaClasseVerte(new \DateTime('2017-09-17 12:00:00'))
        );
        self::assertSame(
            EstCeQueCEst::MORE_THAN_24_HOURS,
            $this->estCeQueCEst->bientotLaClasseVerte(new \DateTime('2017-09-18 12:00:00'))
        );
        self::assertSame(
            EstCeQueCEst::MORE_THAN_12_HOURS,
            $this->estCeQueCEst->bientotLaClasseVerte(new \DateTime('2017-09-20 05:00:00'))
        );
        self::assertSame(
            EstCeQueCEst::MORE_THAN_6_HOURS,
            $this->estCeQueCEst->bientotLaClasseVerte(new \DateTime('2017-09-20 09:00:00'))
        );
        self::assertSame(
            EstCeQueCEst::MORE_THAN_1_HOUR,
            $this->estCeQueCEst->bientotLaClasseVerte(new \DateTime('2017-09-20 16:00:00'))
        );
        self::assertSame(
            EstCeQueCEst::LESS_THAN_1_HOUR,
            $this->estCeQueCEst->bientotLaClasseVerte(new \DateTime('2017-09-20 17:30:00'))
        );
        self::assertSame(
            EstCeQueCEst::IT_S_NOW,
            $this->estCeQueCEst->bientotLaClasseVerte(new \DateTime('2017-09-20 20:00:00'))
        );
        self::assertSame(
            EstCeQueCEst::IT_S_NOW,
            $this->estCeQueCEst->bientotLaClasseVerte(new \DateTime('2017-09-24 17:00:00'))
        );
        self::assertSame(
            EstCeQueCEst::IT_S_OVER,
            $this->estCeQueCEst->bientotLaClasseVerte(new \DateTime('2017-09-24 20:00:00'))
        );
        self::assertSame(
            EstCeQueCEst::MORE_THAN_30_DAYS,
            $this->estCeQueCEst->bientotLaClasseVerte(new \DateTime('2017-09-25 09:00:00'))
        );
    }
}
