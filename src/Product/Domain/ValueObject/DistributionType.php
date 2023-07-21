<?php

declare(strict_types=1);

namespace App\Product\Domain\ValueObject;

use App\Shared\Domain\ValueObject\PrimitivesAwareInterface;

enum DistributionType: string implements PrimitivesAwareInterface
{
    case ONLINE = 'online';
    case OFFLINE = 'offline';

    public function equal(DistributionType $type): bool
    {
        return $type === $this;
    }

    public function toPrimitives(): string
    {
        return $this->value;
    }
}
