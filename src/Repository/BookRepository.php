<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function findBookStartingWith(string $startingTitle): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT title FROM book b
            WHERE b.title LIKE :startingtitle
        ';

        $startingTitleWithPercentage = '%'.$startingTitle.'%';

        $resultSet = $conn->executeQuery(
            $sql, 
            ['startingtitle' => $startingTitleWithPercentage]
        );

        return array_keys($resultSet->fetchAllAssociativeIndexed());
    }
}
