<?php

declare(strict_types=1);

namespace App\Product\Application\Query;

use App\Product\Domain\ValueObject\MediaId;
use App\Shared\Application\Query\QueryInterface;

final class FindMediaQuery implements QueryInterface
{
    public function __construct(
        public readonly MediaId $id,
    ) {
    }
}
