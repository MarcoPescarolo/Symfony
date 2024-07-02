<?php

namespace App\Repository;

use App\Entity\Posteo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Posteo>
 *
 * @method Posteo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Posteo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Posteo[]    findAll()
 * @method Posteo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PosteoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Posteo::class);
    }

//    /**
//     * @return Posteo[] Returns an array of Posteo objects
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

//    public function findOneBySomeField($value): ?Posteo
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
