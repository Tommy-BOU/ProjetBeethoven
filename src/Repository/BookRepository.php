<?php

namespace App\Repository;

use App\DTO\SearchData;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Entity\Book;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    private $searchData;
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator,SearchData $searchData)
    {
        parent::__construct($registry, Book::class);
        $this->searchData = $searchData;
    }

    public function findWithState( int $page, int $id = null,)
    {

        if ($id != null) {
            return $this->createQueryBuilder('b')
                ->join('b.state', 's')
                ->andWhere('b.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getOneOrNullResult();
        } else {
            $data = $this->createQueryBuilder('b')
                ->join('b.state', 's')
                ->orderBy('b.title', 'ASC');

            $query = $data->getQuery()
                ->getResult();
                
            $books = $this->paginator->paginate(
                $query,
                $page,
                10
            );
            return $books;
        }
    }

    public function findAvailable()
    {

        return $this->createQueryBuilder('b')
            ->andWhere('b.available = true')
            ->join('b.state', 's')
            ->orderBy('b.title', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function searchResult(): PaginationInterface
    {
        $data = $this->createQueryBuilder('b')
        ->join('b.state', 's')
        ->orderBy('b.title', 'ASC');

        if ($this->searchData->query)
        {
            $data->andWhere('b.title LIKE :query')
            // ->setParameter('query', '%' . $searchData->query . '%'); //syntaxte alternative
            ->setParameter('query', "%{$this->searchData->query}%");
        }

        $query = $data
            ->getQuery()
            ->getResult();

        $query = $this->paginator->paginate(
            $query,
            $this->searchData->page,
            10
        );
        return $query;
    }
    public function searchResultNoPaginate()
    {
        $data = $this->createQueryBuilder('b')
        ->join('b.state', 's')
        ->orderBy('b.title', 'ASC');

        if ($this->searchData->query)
        {
            $data->andWhere('b.title LIKE :query')
            // ->setParameter('query', '%' . $searchData->query . '%'); //syntaxte alternative
            ->setParameter('query', "%{$this->searchData->query}%");
        }

        $query = $data
            ->getQuery()
            ->getResult();

        return $query;
    }

    //    /**
    //     * @return Book[] Returns an array of Book objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
