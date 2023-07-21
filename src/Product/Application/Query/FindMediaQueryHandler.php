<?php

declare(strict_types=1);

namespace App\Product\Application\Query;

use App\Product\Application\Finder\MediaFinder;
use App\Product\Domain\Model\Media;
use App\Shared\Application\Query\QueryHandlerInterface;

class FindMediaQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly MediaFinder $mediaFinder)
    {
    }

    public function __invoke(FindMediaQuery $query): ?Media
    {
        return $this->mediaFinder->find($query->id);
    }
}
