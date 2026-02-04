<?php

declare(strict_types=1);

namespace OnMoon\Money;

use Money\Currencies;
use Money\Currency as LibCurrency;

/** @psalm-api */
class Currency
{
    /** @psalm-param  non-empty-string $code */
    final protected function __construct(private string $code)
    {
    }

    /** @psalm-param  non-empty-string $code */
    public static function create(string $code): self
    {
        return new static($code);
    }

    /** @psalm-return non-empty-string */
    public function getCode(): string
    {
        return $this->getLibCurrency()->getCode();
    }

    public function equals(self $other): bool
    {
        return $this->getLibCurrency()->equals($other->getLibCurrency());
    }

    public function isAvailableWithin(Currencies $currencies): bool
    {
        return $currencies->contains($this->getLibCurrency());
    }

    public function jsonSerialize(): string
    {
        return $this->getLibCurrency()->jsonSerialize();
    }

    public function __toString(): string
    {
        return (string) $this->getLibCurrency();
    }

    private function getLibCurrency(): LibCurrency
    {
        return new LibCurrency($this->code);
    }
}
