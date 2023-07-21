<?php

namespace App\Product\Infrastructure\ApiPlatform\Filter;

use ApiPlatform\Exception\InvalidValueException;
use ApiPlatform\Metadata\Operation;
use App\Shared\Infrastructure\ApiPlatform\Filter\AbstractFilter;
use App\Shared\Infrastructure\ApiPlatform\Query\QueryBuilder;

final class SizeFilter extends AbstractFilter
{
    private const PROPERTY_NAME = 'size';

    protected function doApply(mixed $value, QueryBuilder $queryBuilder, Operation $operation, array $context): void
    {
        $value = $this->normalizeValue($value);
        if (null === $value) {
            throw new InvalidValueException(\sprintf('Value "%s" should be integer!', $value));
        }

        $queryBuilder->setParameter('size', $value);
    }

    public function getDescription(string $resourceClass): array
    {
        $description[self::PROPERTY_NAME] = [
            'property' => self::PROPERTY_NAME,
            'type' => 'int',
            'required' => false,
            'is_collection' => false,
            'openapi' => [
                'description' => 'Set number of list items.',
                'name' => self::PROPERTY_NAME,
                'schema' => [
                    'type' => 'int',
                ],
            ],
        ];

        return $description;
    }

    protected function getFilterName(): string
    {
        return self::PROPERTY_NAME;
    }

    private function normalizeValue($value): ?int
    {
        if (null !== $value && false === filter_var($value, \FILTER_VALIDATE_INT)) {
            return null;
        }

        return (int)$value;
    }
}
