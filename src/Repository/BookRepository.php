<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function createListQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('b')
            ->leftJoin('b.category', 'c')->addSelect('c')
            ->leftJoin('b.authors', 'a')->addSelect('a')
            ->orderBy('b.id', 'DESC');
    }

    public function applySearch(QueryBuilder $qb, ?string $q): void
    {
        if (!$q) {
            return;
        }
        $qb
            ->andWhere('b.title LIKE :q OR b.isbn LIKE :q')
            ->setParameter('q', '%'.trim($q).'%');
    }
}
