<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
            // ->orWhere('e.date_create = :date')
            ->setParameter('data', $data . '%')
            ->getQuery()
            ->getResult()
        ;
    }

    public function searchEvent($data)
    {

        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

            $sub->select('e.name')
                    ->from('App\Entity\Event', 'e')
                    ->where('e.name LIKE :name')
                    ->setParameter('name', $data);

        $query = $em->createQueryBuilder();

            $query->select('ev.date_create')
                    ->from('App\Entity\Event', 'ev')
                    ->where('ev.date_create = :date')
                    ->setParameter('date', $data);

        return $query->getQuery()->getResult();
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
