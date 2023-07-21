<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Product\Domain\Model\Media;
use App\Product\Infrastructure\ApiPlatform\State\Processor\CreateMediaProcessor;
use App\Product\Infrastructure\ApiPlatform\State\Processor\DeleteMediaProcessor;
use App\Product\Infrastructure\ApiPlatform\State\Processor\UpdateMediaProcessor;
use App\Product\Infrastructure\ApiPlatform\State\Provider\MediaCollectionProvider;
use App\Product\Infrastructure\ApiPlatform\State\Provider\MediaItemProvider;
use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Uuid;

#[ApiResource(
    uriTemplate: '/products/{productId}/media',
    shortName: 'Media',
    operations: [
        new GetCollection(
            provider: MediaCollectionProvider::class,
        ),
        new Post(
            status: 202,
            denormalizationContext: [
                'groups' => ['media:create'],
            ],
            validationContext: [
                'groups' => ['Default', 'media:create'],
            ],
            output: false,
            processor: CreateMediaProcessor::class,
        ),
    ],
    uriVariables: [
        'productId' => new Link(
            toProperty: 'product',
            fromClass: ProductResource::class,
        ),
    ],
    normalizationContext: [
        'groups' => ['media'],
        'skip_null_values' => false,
    ],
    paginationClientItemsPerPage: false,
)]
#[ApiResource(
    shortName: 'Media',
    operations: [
        new Get(
            provider: MediaItemProvider::class,
        ),
        new Put(
            status: 202,
            denormalizationContext: [
                'groups' => ['media:update'],
            ],
            validationContext: [
                'groups' => ['Default', 'media:update'],
            ],
            output: false,
            provider: MediaItemProvider::class,
            processor: UpdateMediaProcessor::class,
        ),
        new Delete(
            status: 202,
            output: false,
            provider: MediaItemProvider::class,
            processor: DeleteMediaProcessor::class,
        ),
    ],
    normalizationContext: [
        'groups' => ['media'],
        'skip_null_values' => false,
    ],
    paginationClientItemsPerPage: false,
)]
final class MediaResource
{
    public function __construct(
        #[Groups(['media'])]
        #[ApiProperty(identifier: true, writable: false)]
        public ?AbstractUid $id = null,

        #[Groups(['media'])]
        public ?ProductResource $product = null,

        #[Groups(['media', 'media:create', 'media:update'])]
        public ?string $name = null,

        #[Groups(['media', 'media:create', 'media:update'])]
        public ?string $description = null,

        #[Groups(['media'])]
        #[ApiProperty(writable: false)]
        public ?DateTimeInterface $createdAt = null,

        #[Groups(['media'])]
        #[ApiProperty(writable: false)]
        public ?DateTimeInterface $updatedAt = null,
    ) {
        $this->id = $id ?? Uuid::v4();
    }

    public static function fromModel(Media $media): self
    {
        return new self(
            id: $media->getId()->getValue(),
            product: ProductResource::fromModel($media->getProduct()),
            name: $media->getName()->getValue(),
            description: $media->getDescription()->getValue(),
            createdAt: $media->getCreatedAt(),
            updatedAt: $media->getUpdatedAt(),
        );
    }
}
