<?php

namespace App\Repository;

use App\Entity\ParticipantOfDraw;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ParticipantOfDraw>
 *
 * @method ParticipantOfDraw|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParticipantOfDraw|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParticipantOfDraw[]    findAll()
 * @method ParticipantOfDraw[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipantOfDrawRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParticipantOfDraw::class);
    }

//    /**
//     * @return ParticipantOfDraw[] Returns an array of ParticipantOfDraw objects
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

//    public function findOneBySomeField($value): ?ParticipantOfDraw
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
