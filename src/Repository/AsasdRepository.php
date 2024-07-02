<?php

namespace App\Repository;

use App\Entity\Asasd;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Asasd>
 *
 * @method Asasd|null find($id, $lockMode = null, $lockVersion = null)
 * @method Asasd|null findOneBy(array $criteria, array $orderBy = null)
 * @method Asasd[]    findAll()
 * @method Asasd[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AsasdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Asasd::class);
    }

//    /**
//     * @return Asasd[] Returns an array of Asasd objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Asasd
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
