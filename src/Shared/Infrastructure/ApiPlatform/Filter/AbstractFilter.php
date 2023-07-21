<?php

namespace App\Shared\Infrastructure\ApiPlatform\Filter;

use ApiPlatform\Metadata\Operation;
use App\Shared\Infrastructure\ApiPlatform\Query\QueryBuilder;

abstract class AbstractFilter implements FilterInterface
{
    public function apply(QueryBuilder $queryBuilder, Operation $operation, array $context): void
    {
        if (!isset($context['filters'][$this->getFilterName()])) {
            return;
        }

        $this->doApply($context['filters'][$this->getFilterName()], $queryBuilder, $operation, $context);
    }

    abstract protected function doApply(mixed $value, QueryBuilder $queryBuilder, Operation $operation, array $context): void;

    abstract protected function getFilterName(): string;
}
