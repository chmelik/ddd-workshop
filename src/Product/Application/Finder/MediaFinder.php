<?php

namespace App\Product\Application\Finder;

use App\Product\Domain\Exception\MissingMediaException;
use App\Product\Domain\Model\Media;
use App\Product\Domain\Repository\MediaRepositoryInterface;
use App\Product\Domain\ValueObject\MediaId;

final class MediaFinder
{
    public function __construct(private readonly MediaRepositoryInterface $repository)
    {
    }

    public function find(MediaId $id): ?Media
    {
        return $this->repository->find($id);
    }

    public function findOrFail(MediaId $id): Media
    {
        $media = $this->find($id);

        if (null === $media) {
            throw new MissingMediaException($id);
        }

        return $media;
    }
}
