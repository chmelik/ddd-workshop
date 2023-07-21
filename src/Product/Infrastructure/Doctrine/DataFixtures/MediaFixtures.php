<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Doctrine\DataFixtures;

use App\Product\Domain\Factory\MediaFactoryInterface;
use App\Product\Domain\Model\Media;
use App\Product\Domain\Model\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Product\Domain\ValueObject\MediaDescription;
use App\Product\Domain\ValueObject\MediaId;
use App\Product\Domain\ValueObject\MediaName;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Component\Uid\Uuid;

#[When(env: 'dev')]
class MediaFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    private array $data = [
        [
            'id' => '344205d3-643d-417b-92d1-7ce82bc6db6a',
            'product' => 0,
            'name' => 'Media 1',
            'description' => 'Description 1',
        ],
        [
            'id' => '67b98cec-51e2-4076-a935-94ef90c107fc',
            'product' => 0,
            'name' => 'Media 2',
            'description' => 'Description 2',
        ]
    ];

    public function __construct(private readonly MediaFactoryInterface $mediaFactory, private readonly ProductRepositoryInterface $productRepository)
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->data as $index => $datum) {
            $product = $this->getProduct($datum['product']);

            $media = $this->mediaFactory->createNew(
                id: new MediaId(Uuid::fromString($datum['id'])),
                product: $product,
                name: new MediaName($datum['name']),
                description: new MediaDescription($datum['description']),
            );
            $product->addMedia($media);
            $this->productRepository->save($product);

            $this->addReference(self::getReferenceName($index), $media);
        }
    }

    public static function getGroups(): array
    {
        return [
            'product',
        ];
    }

    public function getDependencies()
    {
        return [
            ProductFixtures::class,
        ];
    }

    public static function getReferenceName(int $index): string
    {
        return sprintf('%s.%s', Media::class, $index);
    }

    private function getProduct(int $index): Product
    {
        return $this->getReference(ProductFixtures::getReferenceName($index));
    }
}
