<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Doctrine\Repository;

use App\Product\Domain\Model\Media;
use App\Product\Domain\Repository\MediaRepositoryInterface;
use App\Product\Domain\ValueObject\MediaId;
use App\Shared\Infrastructure\Doctrine\Repository\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;

class MediaRepository extends DoctrineRepository implements MediaRepositoryInterface
{
    private const ENTITY_CLASS = Media::class;
    private const ALIAS = 'media';

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, self::ENTITY_CLASS, self::ALIAS);
    }

    public function find(MediaId $id): ?Media
    {
        return $this->entityManager->find(self::ENTITY_CLASS, $id->getValue());
    }
}
