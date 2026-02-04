<?php

declare(strict_types=1);

namespace OnMoon\Money\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Override;

use function array_merge;
use function bcdiv;
use function bcmul;

final class MoneyType extends Type
{
    public const TYPE_NAME = 'money';

    /** @param mixed[] $column */
    #[Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getDecimalTypeDeclarationSQL(
            array_merge(
                $column,
                [
                    'precision' => 10,
                    'scale' => 2,
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

        return bcmul($value, '100', 0);
    }

    #[Override]
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string|null
    {
        if ($value === null) {
            return null;
        }

        /** @psalm-var numeric-string $value */
        $value = (string) $value;

        return bcdiv($value, '100', 2);
    }

    public function getName(): string
    {
        return self::TYPE_NAME;
    }
}
