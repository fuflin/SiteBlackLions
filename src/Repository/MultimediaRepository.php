<?php

namespace App\Repository;

use App\Entity\Multimedia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Multimedia>
 *
 * @method Multimedia|null find($id, $lockMode = null, $lockVersion = null)
 * @method Multimedia|null findOneBy(array $criteria, array $orderBy = null)
 * @method Multimedia[]    findAll()
 * @method Multimedia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MultimediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Multimedia::class);
    }

    public function save(Multimedia $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Multimedia $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getVideos()
    {
        return $this->createQueryBuilder('m')
            ->where("m.media LIKE '%.mp4'")
            ->getQuery()
            ->getResult()
        ;
    }

    public function findVids($event)
    {
        return $this->createQueryBuilder('m')
            ->where("m.media LIKE '%.mp4'")
            ->andWhere("m.event = :event")
            ->setParameter("event", $event)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getImages()
    {
        return $this->createQueryBuilder('m')
            ->where("m.media LIKE '%.jpg'")
            ->orWhere("m.media LIKE '%.jpeg'")
            ->orWhere("m.media LIKE '%.png'")
            ->getQuery()
            ->getResult()
        ;
    }

    public function findImgs($event)
    {
        return $this->createQueryBuilder('m') // création de la requête DQL
            ->where("m.media LIKE '%.jpg'") // condition récupère toute donnée se terminant par .jpg
            ->orWhere("m.media LIKE '%.jpeg'") // ou condition récupère toute donnée se terminant par .jpeg
            ->orWhere("m.media LIKE '%.png'") // ou condition récupère toute donnée se terminant par .png
            ->andWhere("m.event = :event") // identifié un event particulier
            ->setParameter("event", $event) // donner une valeur au paramètre nommé event
            ->getQuery() // exécuter la requête
            ->getResult() // récupére les résultats sous forme forme de tableau
        ;
    }

    public function findMedias($event)
    {
        return $this->createQueryBuilder('m')
            ->select('m.media, m.id')
            ->where('m.event = :event')
            ->setParameter("event", $event)
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return Multimedia[] Returns an array of Multimedia objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Multimedia
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
