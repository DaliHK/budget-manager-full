<?php

namespace App\Repository;

use App\Entity\Spending;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Spending|null find($id, $lockMode = null, $lockVersion = null)
 * @method Spending|null findOneBy(array $criteria, array $orderBy = null)
 * @method Spending[]    findAll()
 * @method Spending[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpendingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Spending::class);
    }

    // /**
    //  * @return Spending[] Returns an array of Spending objects
    //  */
    public function findByDate(\Datetime $date)
    {
        $from = new \DateTime($date->format("Y-m-d") . " 00:00:00");
        $to   = new \DateTime($date->format("Y-m-d") . " 23:59:59");

        $qb = $this->createQueryBuilder("e");
        $qb
            ->andWhere('e.date BETWEEN :from AND :to')
            ->setParameter('from', $from)
            ->setParameter('to', $to);
        $result = $qb->getQuery()->getResult();

        return $result;
    }

    public function findPaidSpendings($month)
    {
        $qb = $this->createQueryBuilder('sp')
            ->Where('MONTH(sp.date) = :month')
            ->andWhere('sp.isPaid = 1')
            ->setParameter('month', $month)
        ;
        return $qb->getQuery()->getResult();
    }

    public function findUnpaidSpendings($month)
    {
        $qb = $this->createQueryBuilder('sp')
            ->Where('MONTH(sp.date) = :month')
            ->andWhere('sp.isPaid = 0')
            ->setParameter('month', $month)
        ;
        return $qb->getQuery()->getResult();
    }

    public function calcLeftSpendingsSum($month){
        $qb = $this->createQueryBuilder('sp')
        ->select('SUM(sp.amount)')
        ->Where('MONTH(sp.date) = :month')
        ->andWhere('sp.isPaid = 0')
        ->setParameter('month', $month)
    ;
    return $qb->getQuery()->getSingleScalarResult();
    }

    public function findById($id)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findSpendingsPaidByInstalment(){
        $qb = $this->createQueryBuilder('sp')
        ->Where('sp.instalment_ending_date > :date ')
        ->setParameter('date', new \DateTime())
    ;
    return $qb->getQuery()->getResult();

    }

    
}
