<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\ApiPlatform\Filter;

trait BooleanFilterTrait
{
    private function normalizeValue($value): ?bool
    {
        if (\in_array($value, [true, 'true', '1'], true)) {
            return true;
        }

        if (\in_array($value, [false, 'false', '0'], true)) {
            return false;
        }

        return null;
    }
}
