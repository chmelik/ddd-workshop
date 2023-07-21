<?php

declare(strict_types=1);

namespace App\Product\Application\Command;

use App\Product\Domain\ValueObject\MediaDescription;
use App\Product\Domain\ValueObject\MediaId;
use App\Product\Domain\ValueObject\MediaName;
use App\Shared\Application\Command\CommandInterface;

final class UpdateMediaCommand implements CommandInterface
{
    public function __construct(
        public readonly MediaId $id,
        public readonly ?MediaName $name,
        public readonly ?MediaDescription $description,
    ) {
    }
}
