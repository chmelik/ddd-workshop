<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Doctrine\DataFixtures;

use App\Product\Domain\Factory\ProductFactoryInterface;
use App\Product\Domain\Model\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Product\Domain\ValueObject\Currency;
use App\Product\Domain\ValueObject\Decimal;
use App\Product\Domain\ValueObject\DistributionType;
use App\Product\Domain\ValueObject\ProductDescription;
use App\Product\Domain\ValueObject\ProductId;
use App\Product\Domain\ValueObject\ProductName;
use App\Product\Domain\ValueObject\ProductPrice;
use App\Product\Domain\ValueObject\ShopReference;
use App\Product\Domain\ValueObject\Toggle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Component\Uid\Uuid;

#[When(env: 'dev')]
class ProductFixtures extends Fixture implements FixtureGroupInterface
{
    private array $data = [
        [
            'id' => '989242e3-decb-43e3-8f18-b465e35c75ca',
            'shop' => '751257cf-4bcf-464d-9d63-2304192aa42c',// Shop 1
            'name' => 'Product 1',
            'description' => 'Description 1',
            'price' => ['amount' => 12, 'currency' => 'UAH'],
            'distributionType' => 'online',
            'enabled' => true,
        ],
        [
            'id' => 'baefe3b0-b019-496c-b449-a850759ca13c',
            'shop' => '751257cf-4bcf-464d-9d63-2304192aa42c',// Shop 1
            'name' => 'Product 2',
            'description' => 'Description 2',
            'price' => ['amount' => 13, 'currency' => 'UAH'],
            'distributionType' => 'online',
            'enabled' => true,
        ],
        [
            'id' => 'b4918a1a-453b-4a87-a9b6-5ca7394748d4',
            'shop' => '751257cf-4bcf-464d-9d63-2304192aa42c',// Shop 1
            'name' => 'Product 3',
            'description' => 'Description 3',
            'price' => ['amount' => 15, 'currency' => 'UAH'],
            'distributionType' => 'online',
            'enabled' => true,
        ],
        [
            'id' => '52611632-590c-43d6-a303-837652dbaebc',
            'shop' => '751257cf-4bcf-464d-9d63-2304192aa42c',// Shop 1
            'name' => 'Product 4',
            'description' => 'Description 4',
            'price' => ['amount' => 4, 'currency' => 'USD'],
            'distributionType' => 'offline',
            'enabled' => true,
        ],
        [
            'id' => 'bceffcb4-18b1-4dc8-ab8f-399d5b786e1c',
            'shop' => '9d05afe8-5370-4f7b-863e-849befa5a8d8',// Shop 2
            'name' => 'Product 5',
            'description' => 'Description 5',
            'price' => ['amount' => 18, 'currency' => 'UAH'],
            'distributionType' => 'offline',
            'enabled' => true,
        ],
        [
            'id' => 'c5583dc7-37f4-4b58-b111-320a8ee90cf8',
            'shop' => '9d05afe8-5370-4f7b-863e-849befa5a8d8',// Shop 2
            'name' => 'Product 6',
            'description' => 'Description 6',
            'price' => ['amount' => 11, 'currency' => 'UAH'],
            'distributionType' => 'offline',
            'enabled' => false,
        ],
    ];

    public function __construct(private readonly ProductFactoryInterface $productFactory, private readonly ProductRepositoryInterface $productRepository)
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->data as $index => $datum) {
            $product = $this->productFactory->createNew(
                id: new ProductId(Uuid::fromString($datum['id'])),
                shop: new ShopReference(Uuid::fromString($datum['shop'])),
                name: new ProductName($datum['name']),
                description: new ProductDescription($datum['description']),
                price: new ProductPrice(
                    amount: new Decimal($datum['price']['amount']),
                    currency: new Currency($datum['price']['currency']),
                ),
                distributionType: DistributionType::from($datum['distributionType']),
                enabled: Toggle::fromBool($datum['enabled']),
            );
            $this->productRepository->save($product);

            $this->addReference(self::getReferenceName($index), $product);
        }
    }

    public static function getGroups(): array
    {
        return [
            'product',
        ];
    }

    public static function getReferenceName(int $index): string
    {
        return sprintf('%s.%s', Product::class, $index);
    }
}
