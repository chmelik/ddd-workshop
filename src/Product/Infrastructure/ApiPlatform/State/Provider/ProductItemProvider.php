<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Product\Application\Query\FindProductQuery;
use App\Product\Domain\Model\Product;
use App\Product\Domain\ValueObject\ProductId;
use App\Product\Infrastructure\ApiPlatform\Resource\ProductResource;
use App\Shared\Application\Query\QueryBusInterface;
use Symfony\Component\Uid\Uuid;

final class ProductItemProvider implements ProviderInterface
{
    public function __construct(private readonly QueryBusInterface $queryBus)
    {
    }

    /**
     * @return ProductResource|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        /** @var string $id */
        $id = $uriVariables['id'];

        /** @var Product|null $model */
        $model = $this->queryBus->ask(
            new FindProductQuery(
                new ProductId(Uuid::fromString($id))
            )
        );

        return null !== $model
            ? ProductResource::fromModel($model)
            : null;
    }
}
