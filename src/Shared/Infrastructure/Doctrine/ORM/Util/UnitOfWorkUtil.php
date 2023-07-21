<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\ORM\Util;

use Doctrine\ORM\EntityManagerInterface;

final class UnitOfWorkUtil
{
    public static function recomputeSingleEntityChangeSet(object $object, EntityManagerInterface $entityManager): void
    {
        $entityManager->persist($object);
        $entityManager->getUnitOfWork()->recomputeSingleEntityChangeSet(
            $entityManager->getClassMetadata(\get_class($object)),
            $object
        );
    }

    private function __construct()
    {
    }
}
