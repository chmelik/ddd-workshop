<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\ODM\MongoDB\Types;

use Doctrine\ODM\MongoDB\Types\Type;
use MongoDB\BSON\Binary;
use Symfony\Component\Uid\AbstractUid;

class UuidType extends Type
{
    private int $binDataType = Binary::TYPE_UUID;

    /**
     * @param AbstractUid|null $value
     *
     * @return Binary|null
     */
    public function convertToDatabaseValue($value): ?Binary
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof Binary) {
            return $value;
        }

        return new Binary($value->toBinary(), $this->binDataType);
    }

    public function convertToPHPValue($value): mixed
    {
        return null !== $value ? ($value instanceof Binary ? AbstractUid::fromBinary($value->getData()) : $value) : null;
    }

    public function closureToMongo(): string
    {
        return sprintf('$return = null !== $value ? new \MongoDB\BSON\Binary($value->toBinary(), %d) : null;', $this->binDataType);
    }

    public function closureToPHP(): string
    {
        return '$return = null !== $value ? ($value instanceof \MongoDB\BSON\Binary ? \Symfony\Component\Uid\AbstractUid::fromBinary($value->getData()) : $value) : null;';
    }
}
