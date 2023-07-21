<?php

declare(strict_types=1);

namespace App\Product\Application\Command;

use App\Product\Domain\ValueObject\MediaId;
use App\Shared\Application\Command\CommandInterface;

final class DeleteMediaCommand implements CommandInterface
{
    public function __construct(
        public readonly MediaId $id,
    ) {
    }
}
