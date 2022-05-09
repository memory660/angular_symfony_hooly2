<?php

namespace App\Repository;

use App\Entity\Reservation;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Reservation $entity, bool $flush = true): void
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
    public function remove(Reservation $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findByDate(int $foodtrackId, int $societyId)
    {
 
        return $this->createQueryBuilder('r')
            ->select('r, d, u, l, s')
            ->join('r.day', 'd')
            ->join('r.foodtrack', 'u')
            ->join('r.location', 'l')   
            ->join('r.society', 's')                                     
            ->where('r.day = d')
            ->andWhere('r.foodtrack = :foodtrack')
            ->setParameter('foodtrack', $foodtrackId)
            /*
            ->andWhere('r.society = :society')
            ->setParameter('society', $societyId)   
            */
            ->andWhere('d.dateReservation > :date')   
            ->setParameter('date', date('Y-m-d'))                                 
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getArrayResult()
            
        ;
    }

    public function findFromSociety(int $societyId, string $dateStr)
    {

        return $this->createQueryBuilder('r')
            ->select('l.locationNo')
            ->join('r.location', 'l')     
            ->join('r.day', 'd')                               
            ->where('r.society = :society')
            ->setParameter('society', $societyId)   
            ->andWhere('d.dateReservation = :date')   
            ->setParameter('date', new DateTime($dateStr))                                 
            ->getQuery()
            ->getArrayResult()            
        ;
    }


    public function findReservationBy($reservationRequest)
    {

        return $this->createQueryBuilder('r')
            ->select('r')
            ->join('r.day', 'd')
            ->join('r.foodtrack', 'u')
            ->join('r.location', 'l')                        
            ->where('r.foodtrack = :foodtrack')
            ->setParameter('foodtrack', $reservationRequest->foodtrackId)
            ->andWhere('s = :society')
            ->setParameter('society', $reservationRequest->societyId)   
            ->andWhere('d.dateReservation = :date')   
            ->setParameter('date', $reservationRequest->date)    
            ->andWhere('l.locationNo = :location')   
            ->setParameter('location', $reservationRequest->no)                                           
            ->getQuery()
            ->getOneOrNullResult()            
        ;
    }

    public function findReservationWithSameDate(int $foodtrackId, $dateReservation)
    {
        return $this->createQueryBuilder('r')
            ->select('r')
            ->join('r.day', 'd')
            ->join('r.foodtrack', 'u')
            ->join('r.location', 'l')                                      
            ->where('r.foodtrack = :foodtrack')
            ->setParameter('foodtrack', $foodtrackId)
            ->andWhere('d.dateReservation = :date')   
            ->setParameter('date', $dateReservation)                                 
            ->getQuery()
            ->getResult()            
        ;
    }

    public function findReservationBetweenDate(int $foodtrackId, int $societyId, $dateMin, $dateMax)
    {

        return $this->createQueryBuilder('r')
            ->select('r')
            ->join('r.day', 'd')
            ->join('r.foodtrack', 'u')
            ->join('r.location', 'l')   
            ->join('r.society', 's')                                      
            ->where('r.foodtrack = :foodtrack')
            ->setParameter('foodtrack', $foodtrackId)
            ->andWhere('s = :society')
            ->setParameter('society', $societyId)   
            ->andWhere('d.dateReservation >= :dateMin')   
            ->setParameter('dateMin', $dateMin)   
            ->andWhere('d.dateReservation <= :dateMax')   
            ->setParameter('dateMax', $dateMax)                                             
            ->getQuery()
            ->getResult()              
        ;
    }

    // /**
    //  * @return Reservation[] Returns an array of Reservation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reservation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
