<?php

namespace App\Shared\Infrastructure\ApiPlatform\Extension;

use ApiPlatform\Metadata\Operation;
use App\Shared\Infrastructure\ApiPlatform\Query\QueryBuilder;

interface ExtensionInterface
{
    public function apply(QueryBuilder $queryBuilder, Operation $operation, array $context): void;
}
