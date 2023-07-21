<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Doctrine\Repository;

use App\Product\Domain\Model\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Product\Domain\ValueObject\ProductId;
use App\Product\Domain\ValueObject\ShopReference;
use App\Shared\Infrastructure\Doctrine\Repository\DoctrineRepository;
use App\Shared\Infrastructure\Doctrine\Repository\QueryNameGeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class ProductRepository extends DoctrineRepository implements ProductRepositoryInterface
{
    private const ENTITY_CLASS = Product::class;
    private const ALIAS = 'product';

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, self::ENTITY_CLASS, self::ALIAS);
    }

    public function save(Product $product): void
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }

    public function remove(Product $product): void
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }

    public function find(ProductId $id): ?Product
    {
        return $this->entityManager->find(self::ENTITY_CLASS, $id->getValue());
    }

    public function withShop(ShopReference $shop): static
    {
        return $this->filter(static function (QueryBuilder $qb, QueryNameGeneratorInterface $queryNameGenerator) use ($shop): void {
            $paramName = $queryNameGenerator->generateParameterName('shop');
            $qb->andWhere(sprintf('%s.shop.id = :%s', self::ALIAS, $paramName))
                ->setParameter($paramName, $shop->getId());
        });
    }

    public function withRecentlyCreatedFirst(): static
    {
        return $this->filter(static function (QueryBuilder $qb): void {
            $qb->addOrderBy(sprintf('%s.createdAt', self::ALIAS), 'DESC');
        });
    }
}
