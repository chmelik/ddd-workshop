<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Repository;

use App\Shared\Domain\Repository\PaginatorInterface;
use App\Shared\Domain\Repository\RepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Webmozart\Assert\Assert;

/**
 * @template T of object
 *
 * @implements RepositoryInterface<T>
 */
abstract class DoctrineRepository implements RepositoryInterface
{
    protected QueryNameGenerator $queryNameGenerator;

    private ?int $page = null;
    private ?int $itemsPerPage = null;

    private QueryBuilder $queryBuilder;

    public function __construct(
        protected EntityManagerInterface $entityManager,
        string $entityClass,
        string $alias,
    )
    {
        $this->queryNameGenerator = new QueryNameGenerator();
        $this->queryBuilder = $this->entityManager->createQueryBuilder()
            ->select($alias)
            ->from($entityClass, $alias);
    }

    public function getIterator(): \Iterator
    {
        if (null !== $paginator = $this->paginator()) {
            yield from $paginator;

            return;
        }

        yield from $this->queryBuilder->getQuery()->getResult();
    }

    public function count(): int
    {
        if (null !== $paginator = $this->paginator()) {
            return count($paginator);
        }

        return (int)(clone $this->queryBuilder)
            ->select('count(1)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function paginator(): ?PaginatorInterface
    {
        if (null === $this->page || null === $this->itemsPerPage) {
            return null;
        }

        $firstResult = ($this->page - 1) * $this->itemsPerPage;
        $maxResults = $this->itemsPerPage;

        $repository = $this->filter(static function (QueryBuilder $qb) use ($firstResult, $maxResults) {
            $qb->setFirstResult($firstResult)->setMaxResults($maxResults);
        });

        /** @var Paginator<T> $paginator */
        $paginator = new Paginator($repository->queryBuilder->getQuery());

        return new DoctrinePaginator($paginator);
    }

    public function withoutPagination(): static
    {
        $cloned = clone $this;
        $cloned->page = null;
        $cloned->itemsPerPage = null;

        return $cloned;
    }

    public function withPagination(int $page, int $itemsPerPage): static
    {
        Assert::positiveInteger($page);
        Assert::positiveInteger($itemsPerPage);

        $cloned = clone $this;
        $cloned->page = $page;
        $cloned->itemsPerPage = $itemsPerPage;

        return $cloned;
    }

    public function onlyOne(): static
    {
        return $this->filter(static function (QueryBuilder $qb): void {
            $qb->setMaxResults(1);
        });
    }

    public function findOne(): mixed
    {
        return $this
            ->onlyOne()
            ->query()
            ->getQuery()
            ->getOneOrNullResult();
    }

    protected function delete(): static
    {
        return $this->filter(static function (QueryBuilder $qb): void {
            $qb->delete();
        });
    }

    /**
     * @return static<T>
     */
    protected function filter(callable $filter): static
    {
        $cloned = clone $this;
        $filter($cloned->queryBuilder, $cloned->queryNameGenerator);

        return $cloned;
    }

    protected function query(): QueryBuilder
    {
        return clone $this->queryBuilder;
    }

    protected function __clone()
    {
        $this->queryNameGenerator = clone $this->queryNameGenerator;
        $this->queryBuilder = clone $this->queryBuilder;
    }
}
