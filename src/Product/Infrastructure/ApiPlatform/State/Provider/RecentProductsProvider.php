<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Product\Application\Query\FindRecentProductsQuery;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Product\Infrastructure\ApiPlatform\Resource\ProductResource;
use App\Shared\Application\Query\QueryBusInterface;
use App\Shared\Infrastructure\ApiPlatform\Query\QueryBuilder;

final class RecentProductsProvider implements ProviderInterface
{
    public function __construct(private readonly QueryBusInterface $queryBus)
    {
    }

    /**
     * @return ProductResource[]
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $queryBuilder = $context['query_builder'] ?? new QueryBuilder();

        $query = new FindRecentProductsQuery(
            size: $queryBuilder->getParameter('size') ?? 5,
        );
        /** @var ProductRepositoryInterface $repository */
        $repository = $this->queryBus->ask($query);

        $resources = [];
        foreach ($repository as $model) {
            $resources[] = ProductResource::fromModel($model);
        }

        return $resources;
    }
}
