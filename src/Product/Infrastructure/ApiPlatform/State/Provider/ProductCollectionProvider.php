<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Product\Application\Query\FindProductsQuery;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Product\Infrastructure\ApiPlatform\Resource\ProductResource;
use App\Shared\Application\Query\QueryBusInterface;
use App\Shared\Infrastructure\ApiPlatform\Query\QueryBuilder;
use App\Shared\Infrastructure\ApiPlatform\State\Paginator;

final class ProductCollectionProvider implements ProviderInterface
{
    public function __construct(private readonly QueryBusInterface $queryBus)
    {
    }

    /**
     * @return Paginator<ProductResource>|list<ProductResource>
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $queryBuilder = $context['query_builder'] ?? new QueryBuilder();

        $query = new FindProductsQuery(
            shop: $queryBuilder->getParameter('shop'),
            page: $queryBuilder->getParameter('page'),
            itemsPerPage: $queryBuilder->getParameter('itemsPerPage'),
        );
        /** @var ProductRepositoryInterface $repository */
        $repository = $this->queryBus->ask($query);

        $resources = [];
        foreach ($repository as $model) {
            $resources[] = ProductResource::fromModel($model);
        }

        if (null !== $paginator = $repository->paginator()) {
            $resources = new Paginator(
                new \ArrayIterator($resources),
                (float)$paginator->getCurrentPage(),
                (float)$paginator->getItemsPerPage(),
                (float)$paginator->getLastPage(),
                (float)$paginator->getTotalItems(),
            );
        }

        return $resources;
    }
}
