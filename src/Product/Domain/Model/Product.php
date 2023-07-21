<?php

declare(strict_types=1);

namespace App\Product\Domain\Model;

use App\Product\Domain\Event\ProductCreatedDomainEvent;
use App\Product\Domain\Event\ProductDeletedDomainEvent;
use App\Product\Domain\Event\ProductDiscountAppliedDomainEvent;
use App\Product\Domain\Event\ProductUpdatedDomainEvent;
use App\Product\Domain\ValueObject\Discount;
use App\Product\Domain\ValueObject\DistributionType;
use App\Product\Domain\ValueObject\MediaDescription;
use App\Product\Domain\ValueObject\MediaId;
use App\Product\Domain\ValueObject\MediaName;
use App\Product\Domain\ValueObject\ProductDescription;
use App\Product\Domain\ValueObject\ProductId;
use App\Product\Domain\ValueObject\ProductName;
use App\Product\Domain\ValueObject\ProductPrice;
use App\Product\Domain\ValueObject\ShopReference;
use App\Product\Domain\ValueObject\Toggle;
use App\Shared\Domain\Model\DomainEventAwareTrait;
use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product AggregateRoot
 */
#[ORM\Entity]
#[ORM\Table(name: 'product__product')]
class Product
{
    use DomainEventAwareTrait;

    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        private readonly ProductId $id,

        #[ORM\Embedded]
        private readonly ShopReference $shop,

        #[ORM\Embedded]
        private ProductName $name,

        #[ORM\Embedded]
        private ProductDescription $description,

        #[ORM\Embedded]
        private ProductPrice $price,

        #[ORM\Column(type: Types::STRING, length: 8, enumType: DistributionType::class)]
        private readonly DistributionType $distributionType,

        #[ORM\Column(type: Types::SMALLINT, enumType: Toggle::class)]
        private Toggle $enabled,

        #[ORM\OneToMany(mappedBy: 'product', targetEntity: Media::class, cascade: ['persist', 'remove'], orphanRemoval: true, indexBy: 'id.value')]
        private Collection $media,

        #[ORM\Column(type: 'datetime_immutable')]
        private readonly DateTimeInterface $createdAt,

        #[ORM\Column(type: 'datetime')]
        private DateTimeInterface $updatedAt,
    ) {
        $this->addDomainEvent(new ProductCreatedDomainEvent(
            aggregateId: $this->id,
            shop: $this->shop,
            name: $this->name,
            description: $this->description,
            price: $this->price,
            distributionType: $this->distributionType,
            enabled: $this->enabled,
            createdAt: $this->createdAt,
            updatedAt: $this->updatedAt,
        ));
    }

    public function getId(): ProductId
    {
        return $this->id;
    }

    public function getShop(): ShopReference
    {
        return $this->shop;
    }

    public function getName(): ProductName
    {
        return $this->name;
    }

    public function getDescription(): ProductDescription
    {
        return $this->description;
    }

    public function getPrice(): ProductPrice
    {
        return $this->price;
    }

    public function getDistributionType(): DistributionType
    {
        return $this->distributionType;
    }

    public function getEnabled(): Toggle
    {
        return $this->enabled;
    }

    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedia(Media $media): void
    {
        if (!$this->hasMedia($media)) {
            $this->media->add($media);
        }
    }

    public function removeMedia(Media|MediaId $media): void
    {
        if ($this->hasMedia($media)) {
            $media = $this->resolveMedia($media);

            $media->remove();
            $this->media->removeElement($media);
        }
    }

    public function hasMedia(Media|MediaId $media): bool
    {
        $key = (string)($media instanceof Media ? $media->getId() : $media);

        return $this->media->containsKey($key);
    }

    public function updateMedia(
        Media|MediaId $media,
        ?MediaName $name = null,
        ?MediaDescription $description = null,
    ): void {
        if ($this->hasMedia($media)) {
            $media = $this->resolveMedia($media);
            $media->update(
                name: $name,
                description: $description,
            );
        }
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function update(
        ?ProductName $name = null,
        ?ProductDescription $description = null,
        ?ProductPrice $price = null,
        ?Toggle $enabled = null,
    ): void {
        $this->name = $name ?? $this->name;
        $this->description = $description ?? $this->description;
        $this->price = $price ?? $this->price;
        $this->enabled = $enabled ?? $this->enabled;
        $this->updateTime();

        $this->addDomainEvent(new ProductUpdatedDomainEvent(
            aggregateId: $this->id,
            name: $name,
            description: $description,
            price: $price,
            enabled: $enabled,
        ));
    }

    public function applyDiscount(Discount $discount): void
    {
        $this->price = $this->price->applyDiscount($discount);
        $this->updateTime();

        $this->addDomainEvent(new ProductDiscountAppliedDomainEvent(
            aggregateId: $this->id,
            discount: $discount,
        ));
    }

    public function remove(): void
    {
        // SoftDelete?
        $this->addDomainEvent(new ProductDeletedDomainEvent(
            aggregateId: $this->id,
        ));
    }

    private function resolveMedia(Media|MediaId $media): Media
    {
        return $media instanceof Media ? $media : $this->media->get((string)$media);
    }

    private function updateTime(): void
    {
        $this->updatedAt = new \DateTime();
    }
}
