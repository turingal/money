<?php

declare(strict_types=1);

namespace OnMoon\Money;

use Money\Currencies;
use Money\Currencies\BitcoinCurrencies;
use Override;

final class Bitcoin extends BaseMoney
{
    #[Override]
    public static function humanReadableName(): string
    {
        return 'Bitcoin';
    }

    #[Override]
    protected static function classSubunits(): int
    {
        return 8;
    }

    #[Override]
    protected static function getAllowedCurrencies(): Currencies
    {
        return new BitcoinCurrencies();
    }
}
