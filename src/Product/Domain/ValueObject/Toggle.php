<?php

namespace App\Product\Domain\ValueObject;

use App\Shared\Domain\ValueObject\PrimitivesAwareInterface;

enum Toggle: int implements PrimitivesAwareInterface
{
    case ENABLED = 1;
    case DISABLED = 0;

    public static function fromBool(bool $value): self
    {
        return match ($value) {
            true => Toggle::ENABLED,
            false => Toggle::DISABLED,
        };
    }

    public function isEnabled(): bool
    {
        return Toggle::ENABLED === $this;
    }

    public function isDisabled(): bool
    {
        return Toggle::DISABLED === $this;
    }

    public function getValue(): bool
    {
        return (bool)$this->value;
    }

    public function toPrimitives(): bool
    {
        return $this->getValue();
    }
}
