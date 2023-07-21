<?php

namespace App\Shared\Infrastructure\ApiPlatform\Extension;

use ApiPlatform\Metadata\Operation;
use App\Shared\Infrastructure\ApiPlatform\Filter\FilterInterface;
use App\Shared\Infrastructure\ApiPlatform\Query\QueryBuilder;
use Psr\Container\ContainerInterface;

final class FilterExtension implements ExtensionInterface
{
    public function __construct(private readonly ContainerInterface $filterLocator)
    {
    }

    public function apply(QueryBuilder $queryBuilder, Operation $operation, array $context): void
    {
        $filters = $operation?->getFilters();
        if (!$filters) {
            return;
        }

        $context['filters'] ??= [];

        foreach ($filters as $filterId) {
            $filter = $this->filterLocator->has($filterId) ? $this->filterLocator->get($filterId) : null;
            if ($filter instanceof FilterInterface) {
                $filter->apply($queryBuilder, $operation, $context);
            }
        }
    }
}
