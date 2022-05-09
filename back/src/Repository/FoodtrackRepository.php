<?php

namespace App\Repository;

use App\Entity\Foodtrack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Foodtrack|null find($id, $lockMode = null, $lockVersion = null)
 * @method Foodtrack|null findOneBy(array $criteria, array $orderBy = null)
 * @method Foodtrack[]    findAll()
 * @method Foodtrack[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FoodtrackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Foodtrack::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Foodtrack $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Foodtrack $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findFoodtracks()
    {
        return $this->createQueryBuilder('u')
            ->getQuery()
            ->getArrayResult()
        ;
    }

    // /**
    //  * @return Foodtrack[] Returns an array of Foodtrack objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Foodtrack
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
