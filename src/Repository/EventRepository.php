<?php

namespace App\Repository;

use App\Entity\Event;
use App\Data\SearchData;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function save(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function searchByNameOrDate($data)
    {
        return $this->createQueryBuilder('e')
            ->select('e.name' , 'e.id')
            ->where('e.name LIKE :data')
            // ->orWhere('e.date_create :data')
            ->setParameter('data', $data . '%')
            ->getQuery()
            ->getResult()
        ;
    }

    public function searchEvent(SearchData $search): array
    {

        $query = $this->createQueryBuilder('e');

            if(!empty($search->q)) {
                $query = $query
                    ->andWhere('e.name LIKE :q')
                    ->setParameter('q', $search->q . '%');
            }

            if (!empty($search->date)) {
                $query = $query
                    ->andWhere('e.date_create LIKE :date')
                    ->setParameter('date', "%{$search->date}%");
            }

        return $query->getQuery()->getResult();
    }


   public function paginationQuery()
   {
       return $this->createQueryBuilder('e')
           ->orderBy('e.date_create', 'DESC')
           ->getQuery()
       ;
   }


//    /**
//     * @return Event[] Returns an array of Event objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Event
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
