<?php

namespace App\Repository;

use App\Entity\ResponseOfQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ResponseOfQuestion>
 *
 * @method ResponseOfQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResponseOfQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResponseOfQuestion[]    findAll()
 * @method ResponseOfQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponseOfQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResponseOfQuestion::class);
    }

//    /**
//     * @return ResponseOfQuestion[] Returns an array of ResponseOfQuestion objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ResponseOfQuestion
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
