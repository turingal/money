<?php

declare(strict_types=1);

namespace OnMoon\Money;

use Money\Currencies;
use Money\Currencies\ISOCurrencies;
use Override;

final class GaapMoney extends BaseMoney
{
    #[Override]
    protected static function classSubunits(): int
    {
        return 4;
    }

    #[Override]
    protected static function getAllowedCurrencies(): Currencies
    {
        return new ISOCurrencies();
    }
}
