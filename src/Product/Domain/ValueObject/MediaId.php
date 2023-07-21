<?php

declare(strict_types=1);

namespace App\Product\Domain\ValueObject;

use App\Shared\Domain\ValueObject\AggregateRootId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class MediaId implements \Stringable
{
    use AggregateRootId;
}
