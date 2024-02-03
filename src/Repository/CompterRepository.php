<?php

namespace App\Repository;

use App\Entity\Compter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Compter>
 *
 * @method Compter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Compter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Compter[]    findAll()
 * @method Compter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Compter::class);
    }

//    /**
//     * @return Compter[] Returns an array of Compter objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Compter
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
