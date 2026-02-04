<?php

declare(strict_types=1);

namespace OnMoon\Money;

use Money\Currencies;
use Money\Currencies\CurrencyList;
use Money\Currencies\ISOCurrencies;
use Override;

/** @psalm-api */
class Money extends BaseMoney
{
    private static Currencies|null $currencies = null;

    #[Override]
    protected static function classSubunits(): int
    {
        return 2;
    }

    #[Override]
    protected static function getAllowedCurrencies(): Currencies
    {
        if (self::$currencies !== null) {
            return self::$currencies;
        }

        return self::initializeCurrencies();
    }

    private static function initializeCurrencies(): Currencies
    {
        $isoCurrencies              = new ISOCurrencies();
        $twoOrLessSubUnitCurrencies = [];

        foreach ($isoCurrencies->getIterator() as $currency) {
            $subUnit = $isoCurrencies->subunitFor($currency);

            if ($subUnit > 2) {
                continue;
            }

            $twoOrLessSubUnitCurrencies[$currency->getCode()] = $subUnit;
        }

        /** @psalm-var array<non-empty-string, int<0, 2>> $twoOrLessSubUnitCurrencies */
        $currencies = new CurrencyList($twoOrLessSubUnitCurrencies);

        self::$currencies = $currencies;

        return $currencies;
    }
}
