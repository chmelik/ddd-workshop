<?php

namespace App\Shared\Infrastructure\ApiPlatform\Extension;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use App\Shared\Infrastructure\ApiPlatform\Query\QueryBuilder;

final class PaginationExtension implements ExtensionInterface
{
    public function __construct(private readonly Pagination $pagination)
    {
    }

    public function apply(QueryBuilder $queryBuilder, Operation $operation, array $context): void
    {
        if (!$this->pagination->isEnabled($operation, $context)) {
            return;
        }

        $queryBuilder->setParameter('page', $this->pagination->getPage($context));
        $queryBuilder->setParameter('itemsPerPage', $this->pagination->getLimit($operation, $context));
    }
}
