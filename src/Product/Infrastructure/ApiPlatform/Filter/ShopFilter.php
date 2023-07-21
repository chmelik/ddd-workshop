<?php

namespace App\Product\Infrastructure\ApiPlatform\Filter;

use ApiPlatform\Exception\InvalidValueException;
use ApiPlatform\Metadata\Operation;
use App\Product\Domain\ValueObject\ShopReference;
use App\Shared\Infrastructure\ApiPlatform\Filter\AbstractFilter;
use App\Shared\Infrastructure\ApiPlatform\Filter\UuidFilterTrait;
use App\Shared\Infrastructure\ApiPlatform\Query\QueryBuilder;

final class ShopFilter extends AbstractFilter
{
    use UuidFilterTrait;

    private const PROPERTY_NAME = 'shop';

    protected function doApply(mixed $value, QueryBuilder $queryBuilder, Operation $operation, array $context): void
    {
        $value = $this->normalizeValue($value);
        if (null === $value) {
            throw new InvalidValueException(\sprintf('Value "%s" should be Uuid!', $value));
        }

        $shop = new ShopReference($value);

        $queryBuilder->setParameter('shop', $shop);
    }

    public function getDescription(string $resourceClass): array
    {
        $description[self::PROPERTY_NAME] = [
            'property' => self::PROPERTY_NAME,
            'type' => 'string',
            'required' => false,
            'is_collection' => false,
            'openapi' => [
                'description' => 'Filter resources by Shop "id".',
                'name' => self::PROPERTY_NAME,
                'schema' => [
                    'type' => 'string',
                ],
            ],
        ];

        return $description;
    }

    protected function getFilterName(): string
    {
        return self::PROPERTY_NAME;
    }
}
