<?php

namespace App\Repository;

use App\Entity\CommentDisLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommentDisLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentDisLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentDisLike[]    findAll()
 * @method CommentDisLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentDisLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentDisLike::class);
    }

    // /**
    //  * @return CommentDisLike[] Returns an array of CommentDisLike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CommentDisLike
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
