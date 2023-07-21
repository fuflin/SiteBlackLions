<?php

namespace App\Repository;

use App\Entity\Participate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Participate>
 *
 * @method Participate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participate[]    findAll()
 * @method Participate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participate::class);
    }

    public function save(Participate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Participate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getParticipe($user_id) {

        return $this->createQueryBuilder('p')
                ->select('p.user_id')
                ->where('p.id = :id')
                ->setParameter('user_id', $user_id)
                ->getQuery()
                ->getResult()
            ;
    }

    public function getInscrit($event) {// requête DQL visant à récupérer le nombre de personnes déjà inscrite à l'event

        return $this->createQueryBuilder('p')// création de la requête DQL
                ->select('COUNT(p.id)')// sélection de la colonne id de la table participate et avec une fonction pour compter le nombre
                ->leftjoin('p.event', 'e')// on fait une jointure avec la table event
                ->where('e.id = :event')// condition id de l'event correspond à la valeur du marqueur nommé
                ->setParameter('event', $event)// donner une valeur au paramètre nommé event
                ->getQuery()// exécuter la requête
                ->getSingleScalarResult() //récupère le resultat sous forme de nombre
            ;
    }

    // public function infoParticipate(){

    //     return $this->createQueryBuilder('p')
    //         ->andWhere('p.id = :id')
    //         ->setParameter('id', $value)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

//    /**
//     * @return Participate[] Returns an array of Participate objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Participate
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
