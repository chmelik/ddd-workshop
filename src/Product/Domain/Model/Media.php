<?php

declare(strict_types=1);

namespace App\Product\Domain\Model;

use App\Product\Domain\Event\ProductMediaCreatedDomainEvent;
use App\Product\Domain\Event\ProductMediaDeletedDomainEvent;
use App\Product\Domain\Event\ProductMediaUpdatedDomainEvent;
use App\Product\Domain\ValueObject\MediaDescription;
use App\Product\Domain\ValueObject\MediaId;
use App\Product\Domain\ValueObject\MediaName;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Internal Entity
 */
#[ORM\Entity]
#[ORM\Table(name: 'product__media')]
class Media
{
    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        private readonly MediaId $id,

        #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'media')]
        #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
        private readonly Product $product,

        #[ORM\Embedded]
        private MediaName $name,

        #[ORM\Embedded]
        private MediaDescription $description,

        #[ORM\Column(type: 'datetime_immutable')]
        private readonly DateTimeInterface $createdAt,

        #[ORM\Column(type: 'datetime')]
        private DateTimeInterface $updatedAt,
    ) {
        $this->product->addDomainEvent(new ProductMediaCreatedDomainEvent(
            aggregateId: $this->product->getId(),
            mediaId: $this->id,
            name: $this->name,
            description: $this->description,
        ));
    }

    public function getId(): MediaId
    {
        return $this->id;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getName(): MediaName
    {
        return $this->name;
    }

    public function getDescription(): MediaDescription
    {
        return $this->description;
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
        ?MediaName $name = null,
        ?MediaDescription $description = null,
    ): void
    {
        $this->name = $name ?? $this->name;
        $this->description = $description ?? $this->description;
        $this->updatedAt = new \DateTime();

        $this->product->addDomainEvent(new ProductMediaUpdatedDomainEvent(
            aggregateId: $this->product->getId(),
            mediaId: $this->id,
            name: $name,
            description: $description,
        ));
    }

    public function remove(): void
    {
        $this->product->addDomainEvent(new ProductMediaDeletedDomainEvent(
            aggregateId: $this->product->getId(),
            mediaId: $this->id,
        ));
    }
}
