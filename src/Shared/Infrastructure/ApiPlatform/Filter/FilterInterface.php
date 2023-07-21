<?php

namespace App\Shared\Infrastructure\ApiPlatform\Filter;

use ApiPlatform\Api\FilterInterface as BaseFilterInterface;
use ApiPlatform\Metadata\Operation;
use App\Shared\Infrastructure\ApiPlatform\Query\QueryBuilder;

interface FilterInterface extends BaseFilterInterface
{
    public function apply(QueryBuilder $queryBuilder, Operation $operation, array $context): void;
}
