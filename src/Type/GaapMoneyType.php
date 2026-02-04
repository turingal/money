<?php

declare(strict_types=1);

namespace OnMoon\Money\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Override;

use function array_merge;
use function bcdiv;
use function bcmul;

final class GaapMoneyType extends Type
{
    public const TYPE_NAME = 'gaap_money';

    /** @param mixed[] $column */
    #[Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDecimalTypeDeclarationSQL(
            array_merge(
                $column,
                [
                    'precision' => 15,
                    'scale' => 4,
                ],
            ),
        );
    }

    #[Override]
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): string|null
    {
        if ($value === null) {
            return null;
        }

        /** @psalm-var numeric-string $value */
        $value = (string) $value;

        return bcmul($value, '10000', 0);
    }

    #[Override]
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string|null
    {
        if ($value === null) {
            return null;
        }

        /** @psalm-var numeric-string $value */
        $value = (string) $value;

        return bcdiv($value, '10000', 4);
    }

    public function getName(): string
    {
        return self::TYPE_NAME;
    }
}
