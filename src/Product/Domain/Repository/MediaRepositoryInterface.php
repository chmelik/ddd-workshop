<?php

declare(strict_types=1);

namespace App\Product\Domain\Repository;

use App\Product\Domain\Model\Media;
use App\Product\Domain\ValueObject\MediaId;
use App\Shared\Domain\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<Media>
 */
interface MediaRepositoryInterface extends RepositoryInterface
{
    public function find(MediaId $id): ?Media;
}
