<?php

namespace App\Shared\Domain\ValueObject;

interface PrimitivesAwareInterface
{
    public function toPrimitives(): mixed;
}
