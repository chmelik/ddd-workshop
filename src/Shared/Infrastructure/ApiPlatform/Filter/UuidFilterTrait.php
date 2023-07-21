<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\ApiPlatform\Filter;

use Symfony\Component\Uid\Uuid;

trait UuidFilterTrait
{
    private function normalizeValue($value): ?Uuid
    {
        return Uuid::isValid($value)
            ? Uuid::fromString($value)
            : null;
    }
}
