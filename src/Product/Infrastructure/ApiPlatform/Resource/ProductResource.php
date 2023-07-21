<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Product\Domain\Model\Product;
use App\Product\Infrastructure\ApiPlatform\Filter\ShopFilter;
use App\Product\Infrastructure\ApiPlatform\Filter\SizeFilter;
use App\Product\Infrastructure\ApiPlatform\Payload\ProductPrice;
use App\Product\Infrastructure\ApiPlatform\Payload\DiscountProduct;
use App\Product\Infrastructure\ApiPlatform\State\Processor\CreateProductProcessor;
use App\Product\Infrastructure\ApiPlatform\State\Processor\DeleteProductProcessor;
use App\Product\Infrastructure\ApiPlatform\State\Processor\DiscountProductProcessor;
use App\Product\Infrastructure\ApiPlatform\State\Processor\UpdateProductProcessor;
use App\Product\Infrastructure\ApiPlatform\State\Provider\ProductCollectionProvider;
use App\Product\Infrastructure\ApiPlatform\State\Provider\ProductItemProvider;
use App\Product\Infrastructure\ApiPlatform\State\Provider\RecentProductsProvider;
use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Product',
    operations: [
        new GetCollection(
            uriTemplate: '/products/recent',
            openapiContext: ['summary' => 'Find recently created Product resources.'],
            paginationEnabled: false,
            filters: [
                SizeFilter::class,
            ],
            provider: RecentProductsProvider::class,
        ),

        new GetCollection(
            filters: [
                ShopFilter::class,
            ],
            provider: ProductCollectionProvider::class,
        ),
        new Post(
            status: 202,
            denormalizationContext: [
                'groups' => ['product:create', 'product_price:create'],
            ],
            validationContext: [
                'groups' => ['Default', 'product:create'],
            ],
            output: false,
            processor: CreateProductProcessor::class,
        ),
        new Get(
            provider: ProductItemProvider::class,
        ),
        new Put(
            status: 202,
            denormalizationContext: [
                'groups' => ['product:update', 'product_price:update'],
            ],
            validationContext: [
                'groups' => ['Default', 'product:update'],
            ],
            output: false,
            provider: ProductItemProvider::class,
            processor: UpdateProductProcessor::class,
        ),
        new Delete(
            status: 202,
            output: false,
            provider: ProductItemProvider::class,
            processor: DeleteProductProcessor::class,
        ),

        new Post(
            uriTemplate: '/products/{id}/discount',
            status: 202,
            openapiContext: ['summary' => 'Apply a discount percentage on a Product resource.'],
            input: DiscountProduct::class,
            output: false,
            provider: ProductItemProvider::class,
            processor: DiscountProductProcessor::class,
        ),
    ],
    normalizationContext: [
        'groups' => ['product', 'product_price'],
        'skip_null_values' => false,
    ],
    paginationClientItemsPerPage: true,
)]
#[ApiFilter(ShopFilter::class)]
final class ProductResource
{
    public function __construct(
        #[Groups(['product'])]
        #[ApiProperty(identifier: true, writable: false)]
        public ?AbstractUid $id = null,

        #[Groups(['product', 'product:create'])]
        public ?AbstractUid $shop = null,

        #[Assert\Sequentially(
            constraints: [
                new Assert\NotBlank(),
                new Assert\Length(
                    min: 2,
                    max: 255,
                ),
            ]
        )]
        #[Groups(['product', 'product:create', 'product:update'])]
        public ?string $name = null,

        #[Groups(['product', 'product:create', 'product:update'])]
        public ?string $description = null,

        #[Groups(['product', 'product:create', 'product:update'])]
        public ?ProductPrice $price = null,

        #[Groups(['product', 'product:create'])]
        public ?string $distributionType = null,

        #[Groups(['product', 'product:create', 'product:update'])]
        public ?bool $enabled = null,

        #[Groups(['product'])]
        #[ApiProperty(writable: false)]
        public ?DateTimeInterface $createdAt = null,

        #[Groups(['product'])]
        #[ApiProperty(writable: false)]
        public ?DateTimeInterface $updatedAt = null,
    ) {
        $this->id = $id ?? Uuid::v4();
    }

    public static function fromModel(Product $product): self
    {
        return new self(
            id: $product->getId()->getValue(),
            shop: $product->getShop()->getId(),
            name: $product->getName()->getValue(),
            description: $product->getDescription()->getValue(),
            price: ProductPrice::fromModel($product->getPrice()),
            distributionType: $product->getDistributionType()->value,
            enabled: $product->getEnabled()->getValue(),
            createdAt: $product->getCreatedAt(),
            updatedAt: $product->getUpdatedAt(),
        );
    }
}
